@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between"><h1>Shipment Batches</h1><a href="{{ route('admin.shipment-batches.create') }}" class="btn btn-warning">New Batch</a></div>
<table class="table card card-body"><tr><th>Name</th><th>Month</th><th>Status</th><th></th></tr>@foreach($batches as $batch)<tr><td>{{ $batch->name }}</td><td>{{ $batch->month->format('M Y') }}</td><td>{{ $batch->status }}</td><td><a href="{{ route('admin.shipment-batches.show',$batch) }}">Open</a></td></tr>@endforeach</table>{{ $batches->links() }}
@endsection
