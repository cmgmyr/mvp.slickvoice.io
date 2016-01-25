<?php

namespace Sv\Http\Controllers;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Stripe\Customer as StripeCustomer;
use Sv\Client;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::orderBy('name', 'ASC')->simplePaginate(15);

        return view('clients.index', compact('clients'));
    }

    /**
     * Imports/Syncs Stripe customers with SV Clients.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import()
    {
        $customers = StripeCustomer::all(['limit' => 100]);
        foreach ($customers->data as $customer) {
            $client = Client::firstOrCreate([
                'stripe_id' => $customer->id,
            ]);

            $client->email = $customer->email;
            $client->name = $customer->description;
            $client->card_last_four = $customer->sources->data[0]->last4;
            $client->card_exp_month = $customer->sources->data[0]->exp_month;
            $client->card_exp_year = $customer->sources->data[0]->exp_year;
            $client->card_brand = $customer->sources->data[0]->brand;
            $client->save();
        }

        return $this->redirectRouteWithSuccess('clients.index', 'Stripe customers have been imported.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $client = new Client();

        return view('clients.create', compact('client'));
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
            'name' => 'required',
            'email' => 'required|email|unique:clients|max:255',
            'card_number' => 'required',
            'csv' => 'required',
            'exp_month' => 'required',
            'exp_year' => 'required',
        ]);

        $customer = StripeCustomer::create([
            'source' => $request->stripeToken,
            'description' => $request->name,
            'email' => $request->email,
        ]);

        Client::create(array_merge($request->all(), [
            'stripe_id' => $customer->id,
            'card_last_four' => $customer->sources->data[0]->last4,
            'card_exp_month' => $customer->sources->data[0]->exp_month,
            'card_exp_year' => $customer->sources->data[0]->exp_year,
            'card_brand' => $customer->sources->data[0]->brand,
        ]));

        return $this->redirectRouteWithSuccess('clients.index', 'The client has been created.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $client = Client::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            $this->redirectBackWithError('The client was not found, please try again.');
        }

        return view('clients.edit', compact('client'));
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
        try {
            $client = Client::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            $this->redirectBackWithError('The client was not found, please try again.');
        }

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:clients,email,' . $id . '|max:255',
        ]);

        $customer = StripeCustomer::retrieve($client->stripe_id);
        $customer->description = $request->name;
        $customer->email = $request->email;
        $customer->save();

        $client->name = $request->name;
        $client->email = $request->email;
        $client->address = $request->address;
        $client->address2 = $request->address2;
        $client->city = $request->city;
        $client->state = $request->state;
        $client->zip = $request->zip;
        $client->phone = $request->phone;
        $client->card_last_four = $customer->sources->data[0]->last4;
        $client->card_exp_month = $customer->sources->data[0]->exp_month;
        $client->card_exp_year = $customer->sources->data[0]->exp_year;
        $client->card_brand = $customer->sources->data[0]->brand;

        $client->save();

        return $this->redirectRouteWithSuccess('clients.index', 'The client has been updated.');
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
            $client = Client::findOrFail($id);

            $customer = StripeCustomer::retrieve($client->stripe_id);
            $customer->delete();

            $client->delete();
        } catch (ModelNotFoundException $e) {
            $this->redirectBackWithError('The client was not found, please try again.');
        } catch (Exception $e) {
            $this->redirectBackWithError('Something unknown went wrong, please try again.');
        }

        return $this->redirectRouteWithSuccess('clients.index', 'The client has been deleted.');
    }
}
