<div class="row g-3">
<div class="col-md-4">
<label for="code" class="form-label">Course code</label>
<input id="code" type="text" name="code" value="{{ old('code', $course?->code) }}"
class="form-control @error('code') is-invalid @enderror">
@error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="col-md-8">
<label for="title" class="form-label">Title</label>
<input id="title" type="text" name="title" value="{{ old('title', $course?->title) }}"
class="form-control @error('title') is-invalid @enderror">
@error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="col-md-4">
<label for="credit_units" class="form-label">Credit units</label>
<input id="credit_units" type="number" name="credit_units"
value="{{ old('credit_units', $course?->credit_units ?? 3) }}"
class="form-control @error('credit_units') is-invalid @enderror">
@error('credit_units')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="col-md-8">
<label for="lecturer_id" class="form-label">Lecturer</label>
<select id="lecturer_id" name="lecturer_id" class="form-select @error('lecturer_id') is-invalid @enderror">
<option value="">-- Not assigned --</option>
@foreach ($lecturers as $lecturer)
<option value="{{ $lecturer->id }}"
@selected(old('lecturer_id', $course?->lecturer_id) == $lecturer->id)>
{{ $lecturer->name }}
</option>
@endforeach
</select>
@error('lecturer_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="col-12">
<label for="description" class="form-label">Description</label>
<textarea id="description" name="description" rows="3"
class="form-control @error('description') is-invalid @enderror">{{ old('description', $course?->description) }}</textarea>
@error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
</div>
<div class="mt-4">
<button type="submit" class="btn btn-primary">Save</button>
<a href="{{ route('courses.index') }}" class="btn btn-outline-secondary">Cancel</a>
</div>