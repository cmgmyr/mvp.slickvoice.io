<?php

namespace Sv\Http\Controllers;

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
        ]);

        CLient::create($request->all());
        // @todo: Create customer in Stripe

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

        $client->name = $request->name;
        $client->email = $request->email;
        $client->address = $request->address;
        $client->address2 = $request->address2;
        $client->city = $request->city;
        $client->state = $request->state;
        $client->zip = $request->zip;
        $client->phone = $request->phone;

        $client->save();
        // @todo: Edit customer in Stripe

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
        } catch (ModelNotFoundException $e) {
            $this->redirectBackWithError('The client was not found, please try again.');
        }

        $stripe_id = $client->stripe_id;
        // @todo: Delete customer in Stripe

        $client->delete();

        return $this->redirectRouteWithSuccess('clients.index', 'The client has been deleted.');
    }
}