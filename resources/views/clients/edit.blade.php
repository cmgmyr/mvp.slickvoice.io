@extends('layouts.app')

@section('title', 'Edit Client')

@section('content')
    <form id="client-form" method="post" action="{{ route('clients.update', $client->id) }}">
        {!! csrf_field() !!}
        {!! method_field('put') !!}
        @include('clients.form')
    </form>
@endsection
