@extends('layouts.app')
@section('content')
<h1>Create Quote</h1>
<form method="POST" action="{{ route('admin.quotes.store') }}" class="card card-body">@csrf
@include('admin.quotes.form')
<button class="btn btn-warning">Create</button>
</form>
@endsection
