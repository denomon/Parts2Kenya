@extends('layouts.app')
@section('title','Your Quote')
@section('content')
<h1>Your quote</h1>
<div class="card"><div class="card-body">
<p><strong>Part:</strong> {{ $quote->partRequest->part_name }}</p>
<p><strong>Vehicle:</strong> {{ $quote->partRequest->vehicle_make }} {{ $quote->partRequest->vehicle_model }} {{ $quote->partRequest->vehicle_year }}</p>
<table class="table">
<thead><tr><th>Description</th><th>Qty</th><th>Unit</th><th>Total</th></tr></thead>
<tbody>@foreach($quote->items as $item)<tr><td>{{ $item->description }}</td><td>{{ $item->quantity }}</td><td>{{ $quote->currency }} {{ number_format($item->unit_price,2) }}</td><td>{{ $quote->currency }} {{ number_format($item->total_price,2) }}</td></tr>@endforeach</tbody>
</table>
<ul class="list-group mb-3">
<li class="list-group-item d-flex justify-content-between"><span>Service margin</span><strong>{{ $quote->currency }} {{ number_format($quote->service_margin,2) }}</strong></li>
<li class="list-group-item d-flex justify-content-between"><span>UK handling</span><strong>{{ $quote->currency }} {{ number_format($quote->uk_handling_fee,2) }}</strong></li>
<li class="list-group-item d-flex justify-content-between"><span>Kenya shipping estimate</span><strong>{{ $quote->currency }} {{ number_format($quote->kenya_shipping_estimate,2) }}</strong></li>
<li class="list-group-item d-flex justify-content-between"><span>Customs estimate</span><strong>{{ $quote->currency }} {{ number_format($quote->customs_estimate,2) }}</strong></li>
<li class="list-group-item d-flex justify-content-between fs-4"><span>Total</span><strong>{{ $quote->currency }} {{ number_format($quote->total(),2) }}</strong></li>
</ul>
<form method="POST" action="{{ route('quotes.public.accept', $quote) }}">@csrf<button class="btn btn-warning btn-lg">Accept quote and pay</button></form>
</div></div>
@endsection
