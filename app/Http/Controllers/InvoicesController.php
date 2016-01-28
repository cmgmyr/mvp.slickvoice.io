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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::orderBy('due_date', 'ASC')->simplePaginate(15);

        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $invoice = new Invoice();
        $clients = Client::orderBy('name', 'ASC')->lists('name', 'id');

        return view('invoices.create', compact('invoice', 'clients'));
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
            'due_date' => 'required',
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

                $invoice = Invoice::create([
                    'client_id' => $request->client_id,
                    'due_date' => Carbon::createFromFormat('Y-m-d', $request->due_date),
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $invoice = Invoice::findOrFail($id);
            $invoice->items()->delete();
            $invoice->delete();
        } catch (ModelNotFoundException $e) {
            $this->redirectBackWithError('The invoice was not found, please try again.');
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
        return view('invoices.partials.invoice-item-editable');
    }
}
