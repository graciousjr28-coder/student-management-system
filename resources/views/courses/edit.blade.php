@extends('layouts.main')
@section('title', 'Edit course')
@section('content')
<h2 class="h4 mb-3">Edit course</h2>
<form method="POST" action="{{ route('courses.update', $course) }}" class="card card-body shadow-sm">
@csrf
@method('PUT')
@include('courses._form', ['course' => $course])
</form>
@endsection