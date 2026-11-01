@extends('layouts.main')
@section('title', 'Dashboard')
@section('content')
<h2 class="h4 mb-4">Welcome, {{ auth()->user()->name }}</h2>
<div class="row g-3">
@foreach ($stats as $stat)
<div class="col-6 col-md-3">
<div class="card text-center shadow-sm">
<div class="card-body">
<div class="display-6">{{ $stat['value'] }}</div>
<div class="text-muted">{{ $stat['label'] }}</div>
</div>
</div>
</div>
@endforeach
</div>
@endsection