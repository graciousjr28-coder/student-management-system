@extends('layouts.main')
@section('title', 'Available courses')
@section('content')
<h2 class="h4 mb-3">Available courses</h2>
<table class="table table-striped bg-white shadow-sm">
<thead><tr><th>Code</th><th>Title</th><th>Units</th><th>Lecturer</th>
<th class="text-end">Action</th></tr></thead>
<tbody>
@foreach ($courses as $course)
<tr>
<td>{{ $course->code }}</td>
<td>{{ $course->title }}</td>
<td>{{ $course->credit_units }}</td>
<td>{{ $course->lecturer?->name ?? 'Not assigned' }}</td>
<td class="text-end">
@if (in_array($course->id, $registeredIds))
<span class="badge bg-success">Registered</span>
@else
@can('register for courses')
<form method="POST" action="{{ route('portal.register', $course) }}">
@csrf
<input type="hidden" name="academic_year" value="2026/2027">
<button type="submit" class="btn btn-sm btn-primary">Register</button>
</form>
@endcan
@endif
</td>
</tr>
@endforeach
</tbody>
</table>
@endsection