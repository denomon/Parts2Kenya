@extends('layouts.app')
@section('content')
<h1>Create Shipment Batch</h1><form method="POST" action="{{ route('admin.shipment-batches.store') }}" class="card card-body">@csrf @include('admin.shipment-batches.form')<button class="btn btn-warning">Create</button></form>
@endsection
