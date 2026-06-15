@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h1 class="mb-3">
                    @if($order->status === \App\Enums\OrderStatus::Paid)
                        Payment successful
                    @else
                        Payment processing
                    @endif
                </h1>

                <p>
                    Your order number is <strong>{{ $order->order_number }}</strong>.
                    {{ $message ?? 'Thank you. We will prepare your order for the next Kenya shipment batch.' }}
                </p>

                <p>
                    Current status:
                    <strong>{{ $order->status->value }}</strong>
                </p>

                <a href="{{ route('tracking.form') }}" class="btn btn-primary">
                    Track Order
                </a>
            </div>
        </div>
    </div>
@endsection