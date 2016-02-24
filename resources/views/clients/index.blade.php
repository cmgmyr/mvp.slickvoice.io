@extends('layouts.app')

@section('title', 'Clients')

@section('content')
    <p>
        <a href="{{ route('clients.create') }}" class="btn btn-primary"><span class="fa fa-plus"></span> Add Client</a>
        <a href="{{ route('clients.import') }}" class="btn btn-default"><span class="fa fa-download"></span> Import</a>
    </p>

    @if($clients->count() > 0)
        <table class="table table-condensed table-hover table-bordered table-striped">
            <thead>
                <tr>
                    <td>Stripe ID</td>
                    <td>Name</td>
                    <td>Email</td>
                    <td>Phone</td>
                    <td>Card</td>
                    <td>Manage</td>
                </tr>
            </thead>
            <tbody>
        @foreach($clients as $client)
            <tr>
                <td>{{ $client->stripe_id }}</td>
                <td>{{ $client->name }}</td>
                <td><a href="mailto:{{ $client->email }}">{{ $client->email }}</a></td>
                <td>{{ $client->phone }}</td>
                <td>
                    <span class="fa fa-{{ $client->card_brand_class }}"></span>
                    {{ $client->card_last_four }} <span class="text-muted">({{ $client->card_exp_month }}/{{ $client->card_exp_year }})</span>
                </td>
                <td>
                    <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-info btn-xs">Edit</a>

                    <a href="{{ route('clients.card-edit', $client->id) }}" class="btn btn-success btn-xs">Swap Card</a>

                    <form method="post" action="{{ route('clients.destroy', $client->id) }}" style="display:inline;"
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
        <p>Sorry, there are no clients yet. Please <a href="{{ route('clients.create') }}">add one</a>!</p>
    @endif
@endsection

@section('pagination')
    <div class="text-center">{!! $clients->render() !!}</div>
@stop
