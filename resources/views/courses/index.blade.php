@extends('layouts.main')
@section('title', 'Courses')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
<h2 class="h4 mb-0">Courses</h2>
@can('create courses')
<a href="{{ route('courses.create') }}" class="btn btn-primary">Add course</a>
@endcan
</div>
<table class="table table-striped bg-white shadow-sm">
<thead>
<tr><th>Code</th><th>Title</th><th>Units</th><th>Lecturer</th>
<th>Students</th><th class="text-end">Actions</th></tr>
</thead>
<tbody>
@forelse ($courses as $course)
<tr>
<td>{{ $course->code }}</td>
<td>{{ $course->title }}</td>
<td>{{ $course->credit_units }}</td>
<td>{{ $course->lecturer?->name ?? 'Not assigned' }}</td>
<td>{{ $course->students_count }}</td>
<td class="text-end">
<a href="{{ route('courses.show', $course) }}" class="btn btn-sm btn-outline-secondary">View</a>
@can('edit courses')
<a href="{{ route('courses.edit', $course) }}" class="btn btn-sm btn-outline-primary">Edit</a>
@endcan
@can('delete courses')
<form method="POST" action="{{ route('courses.destroy', $course) }}" class="d-inline"
onsubmit="return confirm('Delete this course?')">
@csrf
@method('DELETE')
<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
</form>
@endcan
</td>
</tr>
@empty
<tr><td colspan="6" class="text-center text-muted">No courses yet.</td></tr>
@endforelse
</tbody>
</table>
{{ $courses->links() }}
@endsection