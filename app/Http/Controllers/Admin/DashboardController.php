<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PartRequest;
use App\Models\Quote;
use App\Models\ShipmentBatch;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'newRequests' => PartRequest::latest()->limit(8)->get(),
            'ordersAwaitingShipment' => Order::whereIn('status', ['Paid','Ready for Kenya Shipment'])->latest()->limit(8)->get(),
            'counts' => [
                'requests' => PartRequest::count(),
                'quotes' => Quote::count(),
                'paid_orders' => Order::where('status', 'Paid')->count(),
                'batches' => ShipmentBatch::count(),
            ],
        ]);
    }
}
