<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartRequest;
use Illuminate\View\View;

class PartRequestController extends Controller
{
    public function show(PartRequest $partRequest): View
    {
        $partRequest->load(['customer', 'quote', 'order']);

        return view('admin.part-requests.show', compact('partRequest'));
    }
}