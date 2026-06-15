<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Enums\QuoteStatus;
use App\Http\Controllers\Controller;
use App\Mail\QuoteSentMail;
use App\Models\PartRequest;
use App\Models\Quote;
use App\Models\QuoteItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class QuoteController extends Controller
{
    public function index(): View
    {
        return view('admin.quotes.index', ['quotes' => Quote::with('partRequest.customer')->latest()->paginate(20)]);
    }

    public function create(): View
    {
        return view('admin.quotes.create', ['partRequests' => PartRequest::with('customer')->latest()->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'part_request_id' => ['required','exists:part_requests,id'],
            'currency' => ['required','string','size:3'],
            'service_margin' => ['nullable','numeric','min:0'],
            'uk_handling_fee' => ['nullable','numeric','min:0'],
            'kenya_shipping_estimate' => ['nullable','numeric','min:0'],
            'customs_estimate' => ['nullable','numeric','min:0'],
            'expires_at' => ['nullable','date'],
            'notes' => ['nullable','string'],
        ]);
        $quote = Quote::create($data + ['status' => QuoteStatus::Draft]);
        return redirect()->route('admin.quotes.show', $quote)->with('success', 'Quote created. Add quote items next.');
    }

    public function show(Quote $quote): View
    {
        $quote->load('partRequest.customer','items');
        return view('admin.quotes.show', compact('quote'));
    }

    public function edit(Quote $quote): View
    {
        return view('admin.quotes.edit', ['quote' => $quote, 'partRequests' => PartRequest::with('customer')->latest()->get()]);
    }

    public function update(Request $request, Quote $quote): RedirectResponse
    {
        $data = $request->validate([
            'currency' => ['required','string','size:3'],
            'service_margin' => ['nullable','numeric','min:0'],
            'uk_handling_fee' => ['nullable','numeric','min:0'],
            'kenya_shipping_estimate' => ['nullable','numeric','min:0'],
            'customs_estimate' => ['nullable','numeric','min:0'],
            'expires_at' => ['nullable','date'],
            'notes' => ['nullable','string'],
        ]);
        $quote->update($data);
        return redirect()->route('admin.quotes.show', $quote)->with('success', 'Quote updated.');
    }

    public function destroy(Quote $quote): RedirectResponse
    {
        $quote->delete();
        return redirect()->route('admin.quotes.index')->with('success', 'Quote deleted.');
    }

    public function send(Quote $quote): RedirectResponse
    {
        $quote->load('partRequest.customer','items');
        $quote->update(['status' => QuoteStatus::Sent, 'sent_at' => now()]);
        $quote->partRequest->update(['status' => OrderStatus::QuoteSent]);
        Mail::to($quote->partRequest->customer->email)->send(new QuoteSentMail($quote));
        return back()->with('success', 'Quote sent to customer.');
    }

    public function storeItem(Request $request, Quote $quote): RedirectResponse
    {
        $data = $request->validate([
            'description' => ['required','string','max:255'],
            'supplier_name' => ['nullable','string','max:255'],
            'quantity' => ['required','integer','min:1'],
            'unit_price' => ['required','numeric','min:0'],
        ]);
        $data['total_price'] = $data['quantity'] * $data['unit_price'];
        $quote->items()->create($data);
        return back()->with('success', 'Quote item added.');
    }

    public function destroyItem(QuoteItem $quoteItem): RedirectResponse
    {
        $quoteItem->delete();
        return back()->with('success', 'Quote item removed.');
    }
}
