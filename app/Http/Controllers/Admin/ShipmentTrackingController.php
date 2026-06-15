<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ShipmentTrackingController extends Controller
{
    public function store(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required','string','max:255'],
            'location' => ['nullable','string','max:255'],
            'description' => ['nullable','string'],
            'occurred_at' => ['required','date'],
        ]);
        $order->trackingEvents()->create($data);
        return back()->with('success', 'Tracking event added.');
    }
}
