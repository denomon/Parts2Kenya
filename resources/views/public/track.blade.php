@extends('layouts.app')
@section('title','Track Order')
@section('content')
<h1>Track your order</h1>
<form method="POST" action="{{ route('tracking.lookup') }}" class="card card-body mb-4">@csrf
<div class="input-group"><input name="order_number" class="form-control" placeholder="BP-202606-ABC123" required><button class="btn btn-warning">Track</button></div>
</form>
@if(isset($order))
    @if($order)
        <div class="card"><div class="card-body"><h3>{{ $order->order_number }}</h3><p>Status: <strong>{{ $order->status->value }}</strong></p>
        <h5>Tracking events</h5><ul class="list-group">@forelse($order->trackingEvents as $event)<li class="list-group-item"><strong>{{ $event->status }}</strong> — {{ $event->location }}<br><small>{{ $event->occurred_at->format('d M Y H:i') }}</small><p>{{ $event->description }}</p></li>@empty<li class="list-group-item">No tracking updates yet.</li>@endforelse</ul>
        </div></div>
    @else
        <div class="alert alert-warning">Order not found.</div>
    @endif
@endif
@endsection
