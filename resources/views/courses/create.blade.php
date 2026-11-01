@extends('layouts.main')
@section('title', 'Add course')
@section('content')
<h2 class="h4 mb-3">Add course</h2>
<form method="POST" action="{{ route('courses.store') }}" class="card card-body shadow-sm">
@csrf
@include('courses._form', ['course' => null])
</form>
@endsection