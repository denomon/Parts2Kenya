@extends('layouts.app')
@section('content')
<div class="card"><div class="card-body">
<h1>Request received</h1>
<p>Thank you. Your request for <strong>{{ $partRequest->part_name }}</strong> has been received. We will source the part and email you a quote.</p>
<p>Status: <span class="badge badge-status">{{ $partRequest->status->value }}</span></p>
</div></div>
@endsection
