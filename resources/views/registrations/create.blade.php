@extends('layouts.main')
@section('title', 'Register a student')
@section('content')
<h2 class="h4 mb-3">Register a student for a course</h2>
<form method="POST" action="{{ route('registrations.store') }}" class="card card-body shadow-sm">
@csrf
<div class="mb-3">
<label for="student_id" class="form-label">Student</label>
<select id="student_id" name="student_id" class="form-select @error('student_id') is-invalid @enderror">
<option value="">-- Choose a student --</option>
@foreach ($students as $student)
<option value="{{ $student->id }}" @selected(old('student_id') == $student->id)>
{{ $student->student_number }} - {{ $student->full_name }}
</option>
@endforeach
</select>
@error('student_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
<label for="course_id" class="form-label">Course</label>
<select id="course_id" name="course_id" class="form-select @error('course_id') is-invalid @enderror">
<option value="">-- Choose a course --</option>
@foreach ($courses as $course)
<option value="{{ $course->id }}" @selected(old('course_id') == $course->id)>
{{ $course->code }} - {{ $course->title }}
</option>
@endforeach
</select>
@error('course_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
<label for="academic_year" class="form-label">Academic year</label>
<input id="academic_year" type="text" name="academic_year"
value="{{ old('academic_year', '2026/2027') }}"
class="form-control @error('academic_year') is-invalid @enderror">
@error('academic_year')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div>
<button type="submit" class="btn btn-primary">Register</button>
<a href="{{ route('registrations.index') }}" class="btn btn-outline-secondary">Cancel</a>
</div>
</form>
@endsection