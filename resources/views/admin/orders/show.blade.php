@extends('layouts.app')
@section('content')
<h1>Order {{ $order->order_number }}</h1>
<div class="card mb-4"><div class="card-body"><p><strong>Customer:</strong> {{ $order->customer->name }} / {{ $order->customer->email }}</p><p><strong>Total:</strong> {{ $order->currency }} {{ number_format($order->total_amount,2) }}</p><form method="POST" action="{{ route('admin.orders.update',$order) }}" class="row g-2">@csrf @method('PUT')<div class="col-md-4"><select name="status" class="form-select">@foreach(\App\Enums\OrderStatus::cases() as $status)<option value="{{ $status->value }}" @selected($order->status === $status)>{{ $status->value }}</option>@endforeach</select></div><div class="col-md-2"><button class="btn btn-warning">Update Status</button></div></form></div></div>
@if($order->invoice)
    <a class="btn btn-outline-dark mb-3" href="{{ route('admin.invoices.download', $order->invoice) }}">
        Download Invoice
    </a>
@endif
<div class="card"><div class="card-body"><h3>Add Tracking Event</h3><form method="POST" action="{{ route('admin.orders.tracking.store',$order) }}" class="row g-2">@csrf<div class="col-md-3"><input name="status" class="form-control" placeholder="Status" required></div><div class="col-md-3"><input name="location" class="form-control" placeholder="Location"></div><div class="col-md-3"><input name="occurred_at" type="datetime-local" class="form-control" required></div><div class="col-md-3"><button class="btn btn-dark">Add</button></div><div class="col-12"><textarea name="description" class="form-control" placeholder="Description"></textarea></div></form><hr><ul class="list-group">@foreach($order->trackingEvents as $event)<li class="list-group-item"><strong>{{ $event->status }}</strong> {{ $event->location }} - {{ $event->occurred_at->format('d M Y H:i') }}<br>{{ $event->description }}</li>@endforeach</ul></div></div>
@endsection
