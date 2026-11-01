@extends('layouts.main')
@section('title', 'Add student')
@section('content')
<h2 class="h4 mb-3">Add student</h2>
<form method="POST" action="{{ route('students.store') }}" class="card card-body shadow-sm">
@csrf
@include('students._form', ['student' => null])
</form>
@endsection