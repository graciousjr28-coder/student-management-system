<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'Dashboard') | {{ config('app.name') }}</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100 bg-light">
{{-- HEADER --}}
<header class="bg-primary text-white py-3">
<div class="container d-flex justify-content-between align-items-center">
<h1 class="h4 mb-0">{{ config('app.name') }}</h1>
@auth
<div class="d-flex align-items-center gap-3">
<span>{{ auth()->user()->name }} ({{ auth()->user()->getRoleNames()->first() }})</span>
<form method="POST" action="{{ route('logout') }}">
@csrf
<button type="submit" class="btn btn-sm btn-light">Log out</button>
</form>
</div>
@endauth
</div>
</header>
{{-- NAVIGATION (links depend on permissions) --}}
@auth
<nav class="navbar navbar-dark bg-dark">
<div class="container">
<ul class="nav">
<li class="nav-item"><a class="nav-link text-white" href="{{ route('dashboard') }}">Dashboard</a></li>
@can('view students')
<li class="nav-item"><a class="nav-link text-white" href="{{ route('students.index') }}">Students</a></li>
@endcan
@can('view courses')
<li class="nav-item"><a class="nav-link text-white" href="{{ route('courses.index') }}">Courses</a></li>
@endcan
@can('view all registrations')
<li class="nav-item"><a class="nav-link text-white" href="{{ route('registrations.index') }}">Registrations</a></li>
@endcan
@can('manage users')
<li class="nav-item"><a class="nav-link text-white" href="{{ route('users.index') }}">User access</a></li>
@endcan
@can('view assigned courses')
<li class="nav-item"><a class="nav-link text-white" href="{{ route('lecturer.courses') }}">My courses</a></li>
@endcan
@can('view available courses')
<li class="nav-item"><a class="nav-link text-white" href="{{ route('portal.available') }}">Available courses</a></li>
@endcan
@can('view own registrations')
<li class="nav-item"><a class="nav-link text-white" href="{{ route('portal.registrations') }}">My registrations</a></li>
@endcan
</ul>
</div>
</nav>
@endauth
{{-- CONTENT --}}
<main class="container py-4 flex-grow-1">
@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif
@if ($errors->any())
<div class="alert alert-danger">Please fix the errors shown below.</div>
@endif
@yield('content')
</main>
{{-- FOOTER --}}
<footer class="bg-dark text-white-50 text-center py-3 mt-auto">
&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
</footer>
</body>
</html>