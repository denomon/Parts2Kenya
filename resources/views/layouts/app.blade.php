<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Parts2Kenya Export Ltd')</title>
    @vite(['resources/js/app.js'])
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark navbar-bp">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">Parts2Kenya Export Ltd</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('part-requests.create') }}">Request Part</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('tracking.form') }}">Track Order</a></li>
                @auth
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Admin</a></li>
                    <li class="nav-item"><form method="POST" action="{{ route('logout') }}">@csrf<button class="btn btn-sm btn-warning ms-2">Logout</button></form></li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Admin Login</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
<main class="container py-4">
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if($errors->any()) <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div> @endif
    @yield('content')
</main>
<footer class="py-4 text-center text-muted">&copy; {{ date('Y') }} Parts2Kenya Export Ltd</footer>
</body>
</html>
