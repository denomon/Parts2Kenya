@extends('layouts.app')
@section('content')
<h1>Edit Quote</h1>
<form method="POST" action="{{ route('admin.quotes.update',$quote) }}" class="card card-body">@csrf @method('PUT')
@include('admin.quotes.form')
<button class="btn btn-warning">Save</button>
</form>
@endsection
