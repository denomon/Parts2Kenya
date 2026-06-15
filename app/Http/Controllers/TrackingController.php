<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrackingController extends Controller
{
    public function form(): View { return view('public.track'); }

    public function lookup(Request $request): View
    {
        $data = $request->validate(['order_number' => ['required','string']]);
        $order = Order::with('customer','trackingEvents','shipmentBatch')
            ->where('order_number', $data['order_number'])
            ->first();

        return view('public.track', compact('order'));
    }
}
