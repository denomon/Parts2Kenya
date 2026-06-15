@extends('layouts.app')
@section('title','Request a Part')
@section('content')
<h1>Request a UK used car part</h1>
<form method="POST" action="{{ route('part-requests.store') }}" enctype="multipart/form-data" class="card card-body">
@csrf
<div class="row g-3">
    <div class="col-md-6"><label class="form-label">Name</label><input name="name" class="form-control" required value="{{ old('name') }}"></div>
    <div class="col-md-6"><label class="form-label">Email</label><input name="email" type="email" class="form-control" required value="{{ old('email') }}"></div>
    <div class="col-md-4"><label class="form-label">Phone</label><input name="phone" class="form-control" value="{{ old('phone') }}"></div>
    <div class="col-md-4"><label class="form-label">WhatsApp</label><input name="whatsapp" class="form-control" value="{{ old('whatsapp') }}"></div>
    <div class="col-md-4"><label class="form-label">Kenya delivery location</label><input name="kenya_delivery_location" class="form-control" value="{{ old('kenya_delivery_location') }}"></div>
    <div class="col-md-4"><label class="form-label">Vehicle make</label><input name="vehicle_make" class="form-control" required value="{{ old('vehicle_make') }}"></div>
    <div class="col-md-4"><label class="form-label">Vehicle model</label><input name="vehicle_model" class="form-control" required value="{{ old('vehicle_model') }}"></div>
    <div class="col-md-4"><label class="form-label">Year</label><input name="vehicle_year" type="number" class="form-control" value="{{ old('vehicle_year') }}"></div>
    <div class="col-md-6"><label class="form-label">Registration number</label><input name="registration_number" class="form-control" value="{{ old('registration_number') }}"></div>
    <div class="col-md-6"><label class="form-label">VIN</label><input name="vin" class="form-control" value="{{ old('vin') }}"></div>
    <div class="col-md-6"><label class="form-label">Part name</label><input name="part_name" class="form-control" required value="{{ old('part_name') }}"></div>
    <div class="col-md-6"><label class="form-label">Urgency</label><select name="urgency" class="form-select"><option>Normal</option><option>Urgent</option></select></div>
    <div class="col-12"><label class="form-label">Part description</label><textarea name="part_description" class="form-control" rows="4">{{ old('part_description') }}</textarea></div>
    <div class="col-12"><label class="form-label">Photo</label><input name="photo" type="file" class="form-control" accept="image/*"></div>
    <div class="col-12"><button class="btn btn-warning btn-lg">Submit Request</button></div>
</div>
</form>
@endsection
