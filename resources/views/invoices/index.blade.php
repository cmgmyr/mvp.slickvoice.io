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
                <td>ID</td>
                <td>Client</td>
                <td>Due Date</td>
                <td>Total</td>
                <td>Manage</td>
            </tr>
            </thead>
            <tbody>
            @foreach($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->id }}</td>
                    <td>{{ $invoice->client->name }}</td>
                    <td>{{ $invoice->due_date->format('m/d/Y') }}</td>
                    <td>${{ number_format($invoice->items->sum('price'), 2) }}</td>
                    <td>
                        <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-info btn-xs">Edit</a>

                        <form method="post" action="{{ route('invoices.destroy', $invoice->id) }}" style="display:inline;"
                              data-confirm="Are you sure?" class="delete-confirm">
                            {!! csrf_field() !!}
                            {!! method_field('delete') !!}
                            <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                        </form>
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
