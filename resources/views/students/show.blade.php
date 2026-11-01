@extends('layouts.main')
@section('title', $student->full_name)
@section('content')
<h2 class="h4">{{ $student->full_name }}</h2>
<p class="text-muted">
{{ $student->student_number }} | {{ $student->programme }} | Year {{ $student->year_of_study }}
| {{ $student->user?->email }}
</p>
<h3 class="h5 mt-4">Registered courses</h3>
<table class="table table-striped bg-white shadow-sm">
<thead><tr><th>Code</th><th>Title</th><th>Lecturer</th><th>Year</th><th>Status</th></tr></thead>
<tbody>
@forelse ($student->courses as $course)
<tr>
<td>{{ $course->code }}</td>
<td>{{ $course->title }}</td>
<td>{{ $course->lecturer?->name ?? 'Not assigned' }}</td>
<td>{{ $course->pivot->academic_year }}</td>
<td>{{ ucfirst($course->pivot->status) }}</td>
</tr>
@empty
<tr><td colspan="5" class="text-center text-muted">No registrations yet.</td></tr>
@endforelse
</tbody>
</table>
<a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Back</a>
@endsection