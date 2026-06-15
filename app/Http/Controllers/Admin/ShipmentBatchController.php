<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ShipmentBatch;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShipmentBatchController extends Controller
{
    public function index(): View { return view('admin.shipment-batches.index', ['batches' => ShipmentBatch::latest()->paginate(20)]); }
    public function create(): View { return view('admin.shipment-batches.create'); }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'month' => ['required','date'],
            'status' => ['required','string','max:100'],
            'departure_date' => ['nullable','date'],
            'arrival_estimate' => ['nullable','date'],
            'notes' => ['nullable','string'],
        ]);
        $batch = ShipmentBatch::create($data);
        return redirect()->route('admin.shipment-batches.show', $batch)->with('success', 'Shipment batch created.');
    }

    public function show(ShipmentBatch $shipmentBatch): View
    {
        $shipmentBatch->load('orders.customer');
        $availableOrders = Order::whereNull('shipment_batch_id')->whereIn('status', ['Paid','Ready for Kenya Shipment'])->latest()->get();
        return view('admin.shipment-batches.show', compact('shipmentBatch','availableOrders'));
    }

    public function edit(ShipmentBatch $shipmentBatch): View { return view('admin.shipment-batches.edit', compact('shipmentBatch')); }

    public function update(Request $request, ShipmentBatch $shipmentBatch): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'month' => ['required','date'],
            'status' => ['required','string','max:100'],
            'departure_date' => ['nullable','date'],
            'arrival_estimate' => ['nullable','date'],
            'notes' => ['nullable','string'],
        ]);
        $shipmentBatch->update($data);
        return redirect()->route('admin.shipment-batches.show', $shipmentBatch)->with('success', 'Shipment batch updated.');
    }

    public function destroy(ShipmentBatch $shipmentBatch): RedirectResponse
    {
        $shipmentBatch->delete();
        return redirect()->route('admin.shipment-batches.index')->with('success', 'Batch deleted.');
    }

    public function attachOrder(Request $request, ShipmentBatch $shipmentBatch): RedirectResponse
    {
        $data = $request->validate(['order_id' => ['required','exists:orders,id']]);
        $order = Order::findOrFail($data['order_id']);
        $order->update(['shipment_batch_id' => $shipmentBatch->id, 'status' => OrderStatus::ReadyForKenyaShipment]);
        return back()->with('success', 'Order added to batch.');
    }

    public function detachOrder(ShipmentBatch $shipmentBatch, Order $order): RedirectResponse
    {
        $order->update(['shipment_batch_id' => null, 'status' => OrderStatus::Paid]);
        return back()->with('success', 'Order removed from batch.');
    }
}
