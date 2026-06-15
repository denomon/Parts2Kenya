<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(): View { return view('admin.customers.index', ['customers' => Customer::latest()->paginate(20)]); }
    public function show(Customer $customer): View { $customer->load('partRequests','orders'); return view('admin.customers.show', compact('customer')); }
}
