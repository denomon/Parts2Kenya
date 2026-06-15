<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\QuoteStatus;
use App\Models\Order;
use App\Models\Quote;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use App\Models\Payment;
use Stripe\StripeClient;

class PaymentController extends Controller
{
    public function showQuote(Quote $quote): View
    {
        $quote->load('partRequest.customer', 'items');
        return view('public.quote', compact('quote'));
    }

    public function acceptQuote(Request $request, Quote $quote): RedirectResponse
    {
        abort_if($quote->status === QuoteStatus::Expired, 410);
        abort_if($quote->expires_at && $quote->expires_at->isPast(), 410);

        $order = DB::transaction(function () use ($quote) {
            $quote->update(['status' => QuoteStatus::Accepted, 'accepted_at' => now()]);
            $quote->partRequest->update(['status' => OrderStatus::AwaitingPayment]);

            return Order::firstOrCreate(
                ['quote_id' => $quote->id],
                [
                    'customer_id' => $quote->partRequest->customer_id,
                    'status' => OrderStatus::AwaitingPayment,
                    'total_amount' => $quote->total(),
                    'currency' => $quote->currency,
                ]
            );
        });

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'mode' => 'payment',
            'customer_email' => $order->customer->email,
            'line_items' => [[
                'quantity' => 1,
                'price_data' => [
                    'currency' => strtolower($order->currency),
                    'unit_amount' => (int) round($order->total_amount * 100),
                    'product_data' => [
                        'name' => 'Parts2Kenya order '.$order->order_number,
                        'description' => $quote->partRequest->part_name,
                    ],
                ],
            ]],
            'metadata' => ['order_id' => $order->id],
            'success_url' => route('payment.success', $order) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel', $order),
        ]);

        $order->payments()->create([
            'stripe_session_id' => $session->id,
            'amount' => $order->total_amount,
            'currency' => $order->currency,
            'status' => 'pending',
        ]);

        return redirect()->away($session->url);
    }

    public function success(Request $request, Order $order)
    {
        $sessionId = $request->query('session_id');

        if (! $sessionId) {
            return view('public.payment-success', [
                'order' => $order,
                'message' => 'Payment session missing. Stripe will confirm payment shortly.',
            ]);
        }

        $stripe = new StripeClient(config('services.stripe.secret'));

        $session = $stripe->checkout->sessions->retrieve($sessionId);

        if ($session->payment_status === 'paid') {
            $order->update([
                'status' => OrderStatus::Paid,
            ]);

            Payment::updateOrCreate(
                [
                    'stripe_session_id' => $session->id,
                ],
                [
                    'order_id' => $order->id,
                    'amount' => ($session->amount_total ?? 0) / 100,
                    'currency' => strtoupper($session->currency ?? 'GBP'),
                    'status' => 'paid',
                    'stripe_payment_intent_id' => $session->payment_intent ?? null,
                    'paid_at' => now(),
                ]
            );

            return view('public.payment-success', [
                'order' => $order->fresh(),
                'message' => 'Payment received. Your order has been marked as paid.',
            ]);
        }

        return view('public.payment-success', [
            'order' => $order,
            'message' => 'Payment is still processing. Stripe will confirm payment shortly.',
        ]);
    }

    public function cancel(Order $order): View
    {
        return view('public.payment-cancel', compact('order'));
    }
}
