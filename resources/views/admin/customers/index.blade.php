@extends('layouts.app')
@section('content')
<h1>Customers</h1><table class="table card card-body"><tr><th>Name</th><th>Email</th><th>Phone</th><th></th></tr>@foreach($customers as $customer)<tr><td>{{ $customer->name }}</td><td>{{ $customer->email }}</td><td>{{ $customer->phone }}</td><td><a href="{{ route('admin.customers.show',$customer) }}">Open</a></td></tr>@endforeach</table>{{ $customers->links() }}
@endsection
