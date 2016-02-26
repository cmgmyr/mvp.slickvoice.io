@extends('layouts.app')

@section('title', 'Invoice #' . $invoice->public_id)

@section('content')
    <div class="row">
        <div class="col-md-1">
            <div class="form-group">
                <div class="form-group">
                    {{ Form::label('status', 'Status', ['class' => 'control-label']) }}
                    <p class="form-control-static"><span class="btn btn-xs btn-success">Paid</span></p>
                </div>
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group">
                <div class="form-group">
                    {{ Form::label('public_id', 'Invoice ID', ['class' => 'control-label']) }}
                    <p class="form-control-static">{{ $invoice->public_id }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <!-- Client Form Input -->
            <div class="form-group">
                {{ Form::label('client_id', 'Client', ['class' => 'control-label']) }}
                <p class="form-control-static">{{ $invoice->client->name }}</p>
            </div>
        </div>

        <div class="col-md-2">
            <!-- Repeat Form Input -->
            <div class="form-group">
                {{ Form::label('repeat', 'Repeat?', ['class' => 'control-label']) }}
                <p class="form-control-static">{{ $invoice->repeat }}</p>
            </div>
        </div>

        <div class="col-md-1">
            <!-- Due Date Form Input -->
            <div class="form-group">
                {{ Form::label('due_date', 'Due Date', ['class' => 'control-label']) }}
                <p class="form-control-static">{{ $invoice->due_date->tz(env('TIMEZONE'))->format('m/d/Y') }}</p>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group text-right">
                <label for="total" class="control-label">Total</label>
                <p class="form-control-static">
                    Gross: ${{ $total = number_format($invoice->items->sum('price'), 2) }}<br>
                    Fee: (${{ $fee = number_format($invoice->charge_fee, 2) }})<br>
                    Net: ${{ number_format($total - $fee, 2) }}
                </p>
            </div>
        </div>
    </div>
    <hr>

    <div class="row">
        <div id="invoice-items" class="col-md-8 col-md-push-2">
            <h2>Invoice Items</h2>
            <div>
                @foreach($invoice->items as $item)
                    @include('invoices.partials.invoice-item-non-editable', ['item' => $item->toArray()])
                @endforeach
            </div>
        </div>
    </div>

    @include('invoices.partials.logs')
@endsection
