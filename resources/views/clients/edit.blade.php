@extends('layouts.app')

@section('title', 'Edit Client')

@section('content')
    <form id="client-update" class="credit-form" method="post" action="{{ route('clients.update', $client->id) }}">
        {!! csrf_field() !!}
        {!! method_field('put') !!}

        @include('clients.partials.account')

        <!-- Save Form Input -->
        <div class="form-group">
            <button class="btn btn-lg btn-primary" type="submit">Save</button>
        </div>
    </form>
@endsection
