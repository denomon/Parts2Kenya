<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        return view('admin.orders.index', ['orders' => Order::with('customer','shipmentBatch')->latest()->paginate(20)]);
    }

    public function show(Order $order): View
    {
        $order->load('customer','quote.items','shipmentBatch','trackingEvents','invoice');
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate(['status' => ['required','string']]);
        abort_unless(in_array($data['status'], array_column(OrderStatus::cases(), 'value'), true), 422);
        $order->update(['status' => $data['status']]);
        $order->quote->partRequest->update(['status' => $data['status']]);
        return back()->with('success', 'Order status updated.');
    }
}
