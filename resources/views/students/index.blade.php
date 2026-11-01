@extends('layouts.main')
@section('title', 'Students')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
<h2 class="h4 mb-0">Students</h2>
@can('create students')
<a href="{{ route('students.create') }}" class="btn btn-primary">Add student</a>
@endcan
</div>
<table class="table table-striped bg-white shadow-sm">
<thead>
<tr>
<th>Number</th><th>Name</th><th>Programme</th><th>Year</th>
<th>Courses</th><th class="text-end">Actions</th>
</tr>
</thead>
<tbody>
@forelse ($students as $student)
<tr>
<td>{{ $student->student_number }}</td>
<td>{{ $student->full_name }}</td>
<td>{{ $student->programme }}</td>
<td>{{ $student->year_of_study }}</td>
<td>{{ $student->courses_count }}</td>
<td class="text-end">
<a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-outline-secondary">View</a>
@can('edit students')
<a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-outline-primary">Edit</a>
@endcan
@can('delete students')
<form method="POST" action="{{ route('students.destroy', $student) }}" class="d-inline"
onsubmit="return confirm('Delete this student?')">
@csrf
@method('DELETE')
<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
</form>
@endcan
</td>
</tr>
@empty
<tr><td colspan="6" class="text-center text-muted">No students yet.</td></tr>
@endforelse
</tbody>
</table>
{{ $students->links() }}
@endsection