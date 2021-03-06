<?php

namespace Sv\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Sv\Client;
use Sv\Invoice;
use Sv\InvoiceItem;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $invoices = Invoice::orderBy('due_date', 'DESC')
            ->orderBy('public_id', 'DESC')
            ->requestStatus()
            ->simplePaginate(15)
            ->appends($request->except('page'));

        $totals = Invoice::getTotalsByStatuses();

        return view('invoices.index', compact('invoices', 'totals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::orderBy('name', 'ASC')->lists('name', 'id');
        if ($clients->count() == 0) {
            return $this->redirectRouteWithError('clients.create', 'You need to add a client before adding an invoice.');
        }

        $invoice = new Invoice();
        $items = $this->getOldItems();

        return view('invoices.create', compact('invoice', 'clients', 'items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'client_id' => 'required',
            'due_date' => 'required|date',
            'description.0' => 'required',
            'price.0' => 'required',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $items = [];

                foreach ($request->description as $index => $value) {
                    if ($request->description[$index] != '' && $request->price[$index] != '') {
                        $items[] = InvoiceItem::create([
                            'description' => $request->description[$index],
                            'price' => $request->price[$index],
                            'sort' => $index,
                        ]);
                    }
                }

                $due_date = Carbon::createFromFormat('Y-m-d H', $request->due_date . ' 00', env('TIMEZONE'))->timezone('UTC');

                $invoice = Invoice::create([
                    'client_id' => $request->client_id,
                    'public_id' => Invoice::getNextPublicId(),
                    'due_date' => $due_date,
                    'try_on_date' => $due_date,
                    'num_tries' => 0,
                    'status' => 'pending',
                    'repeat' => $request->repeat,
                ]);

                $invoice->items()->saveMany($items);
            });
        } catch (Exception $e) {
            return $this->redirectBackWithError('Sorry, the invoice did not save. Please check your data and try again. -- ' . $e->getMessage());
        }

        return $this->redirectRouteWithSuccess('invoices.index', 'The invoice has been created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        try {
            $invoice = Invoice::whereUuid($uuid)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return $this->redirectBackWithError('The invoice was not found, please try again.');
        }

        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        try {
            $invoice = Invoice::whereUuid($uuid)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return $this->redirectBackWithError('The invoice was not found, please try again.');
        }

        $clients = Client::orderBy('name', 'ASC')->lists('name', 'id');
        $items = $this->getOldItems();

        return view('invoices.edit', compact('invoice', 'clients', 'items'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        try {
            $invoice = Invoice::whereUuid($uuid)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return $this->redirectBackWithError('The invoice was not found, please try again.');
        }

        $this->validate($request, [
            'client_id' => 'required',
            'due_date' => 'required',
            'description.0' => 'required',
            'price.0' => 'required',
        ]);

        try {
            DB::transaction(function () use ($request, $invoice) {
                $invoice->items()->delete();

                $items = [];

                foreach ($request->description as $index => $value) {
                    if ($request->description[$index] != '' && $request->price[$index] != '') {
                        $items[] = InvoiceItem::create([
                            'description' => $request->description[$index],
                            'price' => $request->price[$index],
                            'sort' => $index,
                        ]);
                    }
                }

                $due_date = Carbon::createFromFormat('Y-m-d H', $request->due_date . ' 00', env('TIMEZONE'))->timezone('UTC');

                $invoice->client_id = $request->client_id;
                $invoice->repeat = $request->repeat;
                $invoice->due_date = $due_date;
                if ($invoice->try_on_date->lt($invoice->due_date)) {
                    $invoice->try_on_date = $invoice->due_date;
                }

                $invoice->save();
                $invoice->items()->saveMany($items);
            });
        } catch (Exception $e) {
            return $this->redirectBackWithError('Sorry, the invoice did not save. Please check your data and try again.');
        }

        return $this->redirectRouteWithSuccess('invoices.index', 'The invoice has been updated.');
    }

    /**
     * Refresh the invoice.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function refresh($uuid)
    {
        try {
            $invoice = Invoice::whereUuid($uuid)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return $this->redirectBackWithError('The invoice was not found, please try again.');
        }

        $invoice->num_tries = 0;
        $invoice->try_on_date = Carbon::today(env('TIMEZONE'))->timezone('UTC');
        $invoice->status = 'overdue';
        $invoice->save();

        return $this->redirectRouteWithSuccess('invoices.index', 'The invoice has been refreshed.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        try {
            $invoice = Invoice::whereUuid($uuid)->firstOrFail();
            $invoice->items()->delete();
            $invoice->delete();
        } catch (ModelNotFoundException $e) {
            return $this->redirectBackWithError('The invoice was not found, please try again.');
        }

        return $this->redirectRouteWithSuccess('invoices.index', 'The invoice has been deleted.');
    }

    /**
     * Returns a partial for an editable invoice item.
     *
     * @return \Illuminate\Http\Response
     */
    public function itemCreate()
    {
        $item = [];

        return view('invoices.partials.invoice-item-editable', compact('item'));
    }

    /**
     * Returns old input items when available.
     *
     * @return array
     */
    protected function getOldItems()
    {
        $items = [];
        $descriptions = old('description', []);
        $prices = old('price', []);
        $total = max(count($descriptions), count($prices));
        for ($x = 0; $x < $total; $x++) {
            $items[] = [
                'description' => array_get($descriptions, $x, null),
                'price'       => array_get($prices, $x, null),
            ];
        }

        return $items;
    }
}
