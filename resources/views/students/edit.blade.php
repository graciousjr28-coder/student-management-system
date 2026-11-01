@extends('layouts.main')
@section('title', 'Edit student')
@section('content')
<h2 class="h4 mb-3">Edit student</h2>
<form method="POST" action="{{ route('students.update', $student) }}" class="card card-body shadow-sm">
@csrf
@method('PUT')
@include('students._form', ['student' => $student])
</form>
@endsection