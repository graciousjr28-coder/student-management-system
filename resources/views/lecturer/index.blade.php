@extends('layouts.main')
@section('title', 'My courses')
@section('content')
<h2 class="h4 mb-3">My courses</h2>
<table class="table table-striped bg-white shadow-sm">
<thead><tr><th>Code</th><th>Title</th><th>Units</th><th>Students</th>
<th class="text-end">Action</th></tr></thead>
<tbody>
@forelse ($courses as $course)
<tr>
<td>{{ $course->code }}</td>
<td>{{ $course->title }}</td>
<td>{{ $course->credit_units }}</td>
<td>{{ $course->students_count }}</td>
<td class="text-end">
<a href="{{ route('lecturer.courses.show', $course) }}" class="btn btn-sm btn-outline-primary">View students</a>
</td>
</tr>
@empty
<tr><td colspan="5" class="text-center text-muted">No courses are assigned to you yet.</td></tr>
@endforelse
</tbody>
</table>
@endsection