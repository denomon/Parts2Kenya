@extends('layouts.app')
@section('title','Admin Dashboard')
@section('content')
    <h1>Admin Dashboard</h1>
    <div class="row g-3 mb-4">
        @foreach($counts as $label => $value)
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="text-muted">{{ ucfirst(str_replace('_',' ',$label)) }}</div>
                        <div class="display-6">{{ $value }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body"><h3>Latest Requests</h3>
                    <table class="table">
                        <tr>
                            <th>Part</th>
                            <th>Status</th>
                        </tr>@foreach($newRequests as $r)
                            <tr>
                                <td><a href="{{ route('admin.part-requests.show', $r) }}">{{ $r->part_name }}</a></td>
                                <td><a href="{{ route('admin.part-requests.show', $r) }}">{{ $r->status->value }}</a></td>
                            </tr>
                        @endforeach</table>
                    <a href="{{ route('admin.quotes.create') }}" class="btn btn-warning">Create Quote</a></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body"><h3>Paid Orders Awaiting Shipment</h3>
                    <table class="table">
                        <tr>
                            <th>Order</th>
                            <th>Status</th>
                        </tr>@foreach($ordersAwaitingShipment as $o)
                            <tr>
                                <td><a href="{{ route('admin.orders.show',$o) }}">{{ $o->order_number }}</a></td>
                                <td>{{ $o->status->value }}</td>
                            </tr>
                        @endforeach</table>
                    <a href="{{ route('admin.shipment-batches.index') }}" class="btn btn-dark">Shipment Batches</a>
                </div>
            </div>
        </div>
    </div>
@endsection
