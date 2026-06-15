<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Mail\PartRequestReceivedMail;
use App\Models\Customer;
use App\Models\PartRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class PartRequestController extends Controller
{
    public function create(): View { return view('public.request-part'); }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255'],
            'phone' => ['nullable','string','max:50'],
            'whatsapp' => ['nullable','string','max:50'],
            'kenya_delivery_location' => ['nullable','string','max:255'],
            'vehicle_make' => ['required','string','max:100'],
            'vehicle_model' => ['required','string','max:100'],
            'vehicle_year' => ['nullable','integer','min:1950','max:'.(date('Y')+1)],
            'registration_number' => ['nullable','string','max:50'],
            'vin' => ['nullable','string','max:50'],
            'part_name' => ['required','string','max:255'],
            'part_description' => ['nullable','string'],
            'urgency' => ['nullable','string','max:50'],
            'photo' => ['nullable','image','max:4096'],
        ]);

        $customer = Customer::firstOrCreate(
            ['email' => $data['email']],
            ['name' => $data['name'], 'phone' => $data['phone'] ?? null, 'whatsapp' => $data['whatsapp'] ?? null, 'kenya_delivery_location' => $data['kenya_delivery_location'] ?? null]
        );

        $photoPath = $request->file('photo')?->store('part-requests', 'public');

        $partRequest = PartRequest::create([
            'customer_id' => $customer->id,
            'vehicle_make' => $data['vehicle_make'],
            'vehicle_model' => $data['vehicle_model'],
            'vehicle_year' => $data['vehicle_year'] ?? null,
            'registration_number' => $data['registration_number'] ?? null,
            'vin' => $data['vin'] ?? null,
            'part_name' => $data['part_name'],
            'part_description' => $data['part_description'] ?? null,
            'urgency' => $data['urgency'] ?? null,
            'photo_path' => $photoPath,
            'status' => OrderStatus::PendingSourcing,
        ]);

        Mail::to($customer->email)->send(new PartRequestReceivedMail($partRequest));

        return redirect()->route('part-requests.submitted', $partRequest);
    }

    public function submitted(PartRequest $partRequest): View
    {
        return view('public.request-submitted', compact('partRequest'));
    }
}
