@extends('layouts.app')

@section('content')
    <!-- Jumbotron -->
    <div class="jumbotron">
        <h1>Invoicing and Subscription Billing</h1>
        <p class="lead">SlickVoice.io is the fastest way to get paid online.<br> Create invoices, securely store client credit cards, and schedule reoccuring invoices in seconds.</p>
        <p><a class="btn btn-lg btn-success" href="#" role="button">Coming Soon!</a></p>
    </div>

    <!-- Example row of columns -->
    <div class="row">
        <div class="col-md-4">
            <h2><i class="fa fa-heart"></i> Always Easy</h2>
            <p>Creating clients, invoices, and handling payments couldn't be easier. Using our simple user interface will get you back to what you love doing in no time (not bookkeeping).</p>
        </div>
        <div class="col-md-4">
            <h2><i class="fa fa-money"></i> Always Convenient</h2>
            <p>Quickly set up reoccurring, or one-time, invoices and we'll process them securely (through Stripe) on the due date. We'll notify you once completed, or if there were any issues.</p>
        </div>
        <div class="col-md-4">
            <h2><i class="fa fa-black-tie"></i> Always Professional</h2>
            <p>We've handcrafted beautiful invoice and email templates that are sent automatically. You, and your clients, will love them.</p>
        </div>
    </div>
@endsection
