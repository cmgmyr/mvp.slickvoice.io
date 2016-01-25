@extends('layouts.app')

@section('title', 'Add Client')

@section('content')
    <form id="client-create" class="credit-form" method="post" action="{{ route('clients.store') }}">
        {!! csrf_field() !!}

        <div class="col-md-6">
            <div class="form-group">
                <h3>Client Information</h3>
            </div>

            @include('clients.partials.account')
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <h3>Default Credit Card</h3>
            </div>

            @include('clients.partials.credit-card')

            <!-- Save Form Input -->
            <div class="form-group">
                <button class="btn btn-lg btn-primary" type="submit">Save</button>
            </div>
        </div>
    </form>
@endsection
