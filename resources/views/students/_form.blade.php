@php
$fields = [
['first_name', 'First name', 'text', $student?->first_name],
['last_name', 'Last name', 'text', $student?->last_name],
['email', 'Email (used to log in)', 'email', $student?->user?->email],
['student_number', 'Student number', 'text', $student?->student_number],
['phone', 'Phone', 'text', $student?->phone],
['programme', 'Programme', 'text', $student?->programme ?? 'Bachelor of Business Computing'],
['year_of_study', 'Year of study (1 to 4)', 'number', $student?->year_of_study ?? 1],
['password', 'Password (leave blank to keep the current one; a new student gets "password")', 'password', null],
];
@endphp
<div class="row g-3">
@foreach ($fields as [$name, $label, $type, $value])
<div class="col-md-6">
<label for="{{ $name }}" class="form-label">{{ $label }}</label>
<input id="{{ $name }}" type="{{ $type }}" name="{{ $name }}"
value="{{ $type === 'password' ? '' : old($name, $value) }}"
class="form-control @error($name) is-invalid @enderror">
@error($name)
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>
@endforeach
</div>
<div class="mt-4">
<button type="submit" class="btn btn-primary">Save</button>
<a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Cancel</a>
</div>