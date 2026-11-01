@extends('layouts.main')
@section('title', 'My registrations')
@section('content')
<h2 class="h4 mb-3">My registrations</h2>
<table class="table table-striped bg-white shadow-sm">
<thead><tr><th>Code</th><th>Title</th><th>Lecturer</th><th>Year</th>
<th>Status</th><th class="text-end">Action</th></tr></thead>
<tbody>
@forelse ($registrations as $registration)
<tr>
<td>{{ $registration->course->code }}</td>
<td>{{ $registration->course->title }}</td>
<td>{{ $registration->course->lecturer?->name ?? 'Not assigned' }}</td>
<td>{{ $registration->academic_year }}</td>
<td>{{ ucfirst($registration->status) }}</td>
<td class="text-end">
<form method="POST" action="{{ route('portal.drop', $registration) }}"
onsubmit="return confirm('Drop this course?')">
@csrf
@method('DELETE')
<button type="submit" class="btn btn-sm btn-outline-danger">Drop</button>
</form>
</td>
</tr>
@empty
<tr><td colspan="6" class="text-center text-muted">You have not registered for any course yet.</td></tr>
@endforelse
</tbody>
</table>
@endsection