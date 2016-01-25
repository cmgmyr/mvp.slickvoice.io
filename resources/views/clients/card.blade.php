@extends('layouts.app')

@section('title', 'Swap Client Card')

@section('content')
    <form id="client-card" class="credit-form" method="post" action="{{ route('clients.card-update', $client->id) }}">
        {!! csrf_field() !!}
        {!! method_field('put') !!}

        @include('clients.partials.credit-card')

        <!-- Save Form Input -->
        <div class="form-group">
            <button class="btn btn-lg btn-primary" type="submit">Save</button>
        </div>
    </form>
@endsection
