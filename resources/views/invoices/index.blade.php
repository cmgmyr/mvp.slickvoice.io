@extends('layouts.app')

@section('title', 'Invoices')

@section('content')
    <p>
        <a href="{{ route('invoices.create') }}" class="btn btn-primary"><span class="fa fa-plus"></span> Add Invoice</a>
    </p>

    @if($invoices->count() > 0)
        <table class="table table-condensed table-hover table-bordered table-striped">
            <thead>
            <tr>
                <td>Status</td>
                <td>ID</td>
                <td>Client</td>
                <td>Due Date</td>
                <td>Total</td>
                <td>Repeat?</td>
                <td>Manage</td>
            </tr>
            </thead>
            <tbody>
            @foreach($invoices as $invoice)
                <tr>
                    <td>
                        @if($invoice->status == 'paid')
                            <span class="btn btn-xs btn-success">Paid</span>
                        @elseif($invoice->status == 'overdue')
                            <span class="btn btn-xs btn-warning">Overdue</span>
                        @elseif($invoice->status == 'error')
                            <span class="btn btn-xs btn-danger">Error</span>
                        @else
                            <span class="btn btn-xs btn-info">Pending</span>
                        @endif
                    </td>
                    <td>{{ $invoice->public_id }}</td>
                    <td>{{ $invoice->client->name }}</td>
                    <td>{{ $invoice->due_date->format('m/d/Y') }}</td>
                    <td>${{ number_format($invoice->items->sum('price'), 2) }}</td>
                    <td>{{ $invoice->repeat == 'no' ? '' : 'per ' . $invoice->repeat }}</td>
                    <td>
                        @if($invoice->status != 'paid')
                            <a href="{{ route('invoices.edit', $invoice->uuid) }}" class="btn btn-info btn-xs"><span class="fa fa-pencil"></span></a>
                            <a href="{{ route('invoices.refresh', $invoice->uuid) }}" class="btn btn-success btn-xs"><span class="fa fa-refresh"></span></a>

                            <form method="post" action="{{ route('invoices.destroy', $invoice->uuid) }}" style="display:inline;"
                                  data-confirm="Are you sure?" class="delete-confirm">
                                {!! csrf_field() !!}
                                {!! method_field('delete') !!}
                                <button type="submit" class="btn btn-danger btn-xs"><span class="fa fa-trash"></span></button>
                            </form>
                        @else
                            <a href="{{ route('invoices.show', $invoice->uuid) }}" class="btn btn-success btn-xs"><span class="fa fa-eye"></span></a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>Sorry, there are no invoices yet. Please <a href="{{ route('invoices.create') }}">add one</a>!</p>
    @endif
@endsection

@section('pagination')
    <div class="text-center">{!! $invoices->render() !!}</div>
@stop
