<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\Response;

class InvoiceController extends Controller
{
    public function download(Invoice $invoice): Response
    {
        $invoice->load('order.customer','order.quote.items');
        return Pdf::loadView('pdf.invoice', compact('invoice'))->download($invoice->invoice_number.'.pdf');
    }
}
