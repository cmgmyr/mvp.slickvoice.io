<?php

namespace Sv\Http\Controllers;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }
}
