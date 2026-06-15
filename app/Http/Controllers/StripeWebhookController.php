<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Mail\PaymentReceivedMail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Stripe\StripeClient;
use Stripe\Webhook;
use Symfony\Component\HttpFoundation\Response;

class StripeWebhookController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature');

        $event = Webhook::constructEvent($payload, $signature, config('services.stripe.webhook_secret'));

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            $order = Order::find($session->metadata->order_id ?? null);

            if ($order) {
                $order->update(['status' => OrderStatus::Paid]);
                $order->quote->partRequest->update(['status' => OrderStatus::Paid]);
                $order->payments()->where('stripe_session_id', $session->id)->update([
                    'status' => 'paid',
                    'stripe_payment_intent' => $session->payment_intent,
                    'paid_at' => now(),
                ]);
                $order->invoices()->firstOrCreate([], [
                    'amount' => $order->total_amount,
                    'currency' => $order->currency,
                    'issued_at' => now(),
                ]);
                Mail::to($order->customer->email)->send(new PaymentReceivedMail($order));
            }
        }

        return response('Webhook handled', 200);
    }
}
