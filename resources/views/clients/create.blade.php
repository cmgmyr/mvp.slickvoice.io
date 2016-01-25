@extends('layouts.app')

@section('title', 'Add Client')

@section('content')
    <form id="client-form" method="post" action="{{ route('clients.store') }}">
        {!! csrf_field() !!}
        @include('clients.form')
    </form>
@endsection
