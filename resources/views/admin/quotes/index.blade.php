@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between"><h1>Quotes</h1><a class="btn btn-warning" href="{{ route('admin.quotes.create') }}">New Quote</a></div>
<table class="table card card-body"><tr><th>ID</th><th>Customer</th><th>Status</th><th>Total</th><th></th></tr>@foreach($quotes as $quote)<tr><td>{{ $quote->id }}</td><td>{{ $quote->partRequest->customer->name }}</td><td>{{ $quote->status->value }}</td><td>{{ $quote->currency }} {{ number_format($quote->total(),2) }}</td><td><a href="{{ route('admin.quotes.show',$quote) }}">Open</a></td></tr>@endforeach</table>{{ $quotes->links() }}
@endsection
