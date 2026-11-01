@extends('layouts.main')
@section('title', $course->code)
@section('content')
<h2 class="h4">{{ $course->code }}: {{ $course->title }}</h2>
<p class="text-muted">{{ $course->credit_units }} credit units</p>
<h3 class="h5 mt-4">Registered students</h3>
<table class="table table-striped bg-white shadow-sm">
<thead><tr><th>Number</th><th>Name</th><th>Programme</th><th>Year</th></tr></thead>
<tbody>
@forelse ($course->students as $student)
<tr>
<td>{{ $student->student_number }}</td>
<td>{{ $student->full_name }}</td>
<td>{{ $student->programme }}</td>
<td>{{ $student->year_of_study }}</td>
</tr>
@empty
<tr><td colspan="4" class="text-center text-muted">No students registered yet.</td></tr>
@endforelse
</tbody>
</table>
<a href="{{ route('lecturer.courses') }}" class="btn btn-outline-secondary">Back</a>
@endsection