@extends('layouts.app')
@section('content')
<h1>Edit Shipment Batch</h1><form method="POST" action="{{ route('admin.shipment-batches.update',$shipmentBatch) }}" class="card card-body">@csrf @method('PUT') @include('admin.shipment-batches.form')<button class="btn btn-warning">Save</button></form>
@endsection
