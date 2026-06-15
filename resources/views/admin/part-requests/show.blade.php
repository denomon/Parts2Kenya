@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1>Part Request Details</h1>
                <p class="text-muted mb-0">
                    Request #{{ $partRequest->id }}
                </p>
            </div>

            <a href="{{ route('admin.quotes.create', ['part_request_id' => $partRequest->id]) }}" class="btn btn-warning">
                Create Quote
            </a>
        </div>

        <div class="card mb-4">
            <div class="card-header fw-bold">
                Customer
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $partRequest->customer->name ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $partRequest->customer->email ?? 'N/A' }}</p>
                <p><strong>Phone:</strong> {{ $partRequest->customer->phone ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header fw-bold">
                Vehicle Details
            </div>
            <div class="card-body">
                <p><strong>Make:</strong> {{ $partRequest->vehicle_make ?? 'N/A' }}</p>
                <p><strong>Model:</strong> {{ $partRequest->vehicle_model ?? 'N/A' }}</p>
                <p><strong>Year:</strong> {{ $partRequest->vehicle_year ?? 'N/A' }}</p>
                <p><strong>Registration/VIN:</strong> {{ $partRequest->registration_or_vin ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header fw-bold">
                Requested Part
            </div>
            <div class="card-body">
                <p><strong>Part:</strong> {{ $partRequest->part_name }}</p>
                <p><strong>Description:</strong> {{ $partRequest->description ?? 'N/A' }}</p>
                <p><strong>Urgency:</strong> {{ $partRequest->urgency ?? 'N/A' }}</p>
                <p><strong>Status:</strong> {{ $partRequest->status->value ?? $partRequest->status }}</p>
                <p><strong>Kenya Delivery Location:</strong> {{ $partRequest->kenya_delivery_location ?? 'N/A' }}</p>

                @if($partRequest->photo_path)
                    <hr>
                    <p><strong>Uploaded Photo:</strong></p>
                    <img src="{{ asset('storage/' . $partRequest->photo_path) }}" class="img-fluid rounded border" style="max-width: 400px;">
                @endif
            </div>
        </div>

        @if($partRequest->quote)
            <div class="card mb-4">
                <div class="card-header fw-bold">
                    Quote
                </div>
                <div class="card-body">
                    <p><strong>Quote Status:</strong> {{ $partRequest->quote->status->value ?? $partRequest->quote->status }}</p>
                    <p><strong>Total:</strong> {{ $partRequest->quote->currency ?? 'GBP' }} {{ number_format($partRequest->quote->total_amount, 2) }}</p>

                    <a href="{{ route('admin.quotes.show', $partRequest->quote) }}" class="btn btn-outline-primary">
                        View Quote
                    </a>
                </div>
            </div>
        @endif

        @if($partRequest->order)
            <div class="card mb-4">
                <div class="card-header fw-bold">
                    Order
                </div>
                <div class="card-body">
                    <p><strong>Order Number:</strong> {{ $partRequest->order->order_number }}</p>
                    <p><strong>Status:</strong> {{ $partRequest->order->status->value ?? $partRequest->order->status }}</p>

                    <a href="{{ route('admin.orders.show', $partRequest->order) }}" class="btn btn-outline-dark">
                        View Order
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection