@extends('layouts.app')
@section('content')
<h1>{{ $customer->name }}</h1><div class="card"><div class="card-body"><p>{{ $customer->email }} | {{ $customer->phone }} | {{ $customer->whatsapp }}</p><p>Kenya location: {{ $customer->kenya_delivery_location }}</p></div></div>
@endsection
