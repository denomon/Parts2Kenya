@extends('layouts.app')
@section('content')
<div class="card"><div class="card-body"><h1>Payment cancelled</h1><p>Your order <strong>{{ $order->order_number }}</strong> has not been paid. You can return to your quote link to try again.</p></div></div>
@endsection
