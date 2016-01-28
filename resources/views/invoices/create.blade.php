@extends('layouts.app')

@section('title', 'Add Invoice')

@section('content')
    {!! Form::model($invoice, ['route' => 'invoices.store', 'method' => 'post', 'id' => 'invoice-create']) !!}
        @include('invoices.partials.form')
    {!! Form::close() !!}
@endsection
