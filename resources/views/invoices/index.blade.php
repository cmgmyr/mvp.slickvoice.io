@extends('layouts.app')

@section('title', 'Invoices')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <a href="{{ route('invoices.create') }}" class="btn btn-primary"><span class="fa fa-plus"></span> Add Invoice</a>
        </div>
        <div class="col-md-6 text-right">
            @include('invoices.partials.status-buttons')
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            @if($invoices->count() > 0)
                @include('invoices.partials.invoice-table')
            @else
                <p>Sorry, there are no invoices yet. Please <a href="{{ route('invoices.create') }}">add one</a>!</p>
            @endif
        </div>
    </div>
@endsection

@section('pagination')
    <div class="text-center">{!! $invoices->render() !!}</div>
@stop
