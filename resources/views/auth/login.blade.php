@extends('layouts.app')
@section('content')
<div class="row justify-content-center"><div class="col-md-5"><div class="card"><div class="card-body">
<h1 class="h3">Admin Login</h1>
<form method="POST" action="{{ route('login') }}">@csrf
<label class="form-label">Email</label><input name="email" type="email" class="form-control mb-3" required>
<label class="form-label">Password</label><input name="password" type="password" class="form-control mb-3" required>
<button class="btn btn-warning w-100">Login</button>
</form>
</div></div></div></div>
@endsection
