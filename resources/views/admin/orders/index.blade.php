@extends('layouts.app')
@section('content')
    <h1>Orders</h1>
    <table class="table card card-body">
        <tr>
            <th>Order</th>
            <th>Customer</th>
            <th>Status</th>
            <th>Total</th>
            <th>Batch</th>
            <th></th>
        </tr>@foreach($orders as $order)
            <tr>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->customer->name }}</td>
                <td>{{ $order->status->value }}</td>
                <td>{{ $order->currency }} {{ number_format($order->total_amount,2) }}</td>
                <td>{{ $order->shipmentBatch?->name }}</td>
                <td><a href="{{ route('admin.orders.show',$order) }}">Open</a></td>
            </tr>
        @endforeach</table>{{ $orders->links() }}
@endsection
