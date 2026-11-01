@extends('layouts.main')
@section('title', 'Registrations')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
<h2 class="h4 mb-0">Course registrations</h2>
@can('manage registrations')
<a href="{{ route('registrations.create') }}" class="btn btn-primary">Register a student</a>
@endcan
</div>
<table class="table table-striped bg-white shadow-sm">
<thead>
<tr><th>Student</th><th>Course</th><th>Year</th><th>Status</th>
<th class="text-end">Actions</th></tr>
</thead>
<tbody>
@forelse ($registrations as $registration)
<tr>
<td>{{ $registration->student->student_number }} - {{ $registration->student->full_name }}</td>
<td>{{ $registration->course->code }} - {{ $registration->course->title }}</td>
<td>{{ $registration->academic_year }}</td>
<td>{{ ucfirst($registration->status) }}</td>
<td class="text-end">
@can('manage registrations')
<form method="POST" action="{{ route('registrations.destroy', $registration) }}" class="d-inline"
onsubmit="return confirm('Remove this registration?')">
@csrf
@method('DELETE')
<button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
</form>
@endcan
</td>
</tr>
@empty
<tr><td colspan="5" class="text-center text-muted">No registrations yet.</td></tr>
@endforelse
</tbody>
</table>
{{ $registrations->links() }}
@endsection