@extends('layouts.main')
@section('title', 'User access')
@section('content')
<h2 class="h4 mb-3">User access</h2>
<table class="table table-striped bg-white shadow-sm align-middle">
<thead><tr><th>Name</th><th>Email</th><th>Role</th><th class="text-end">Change role</th></tr></thead>
<tbody>
@foreach ($users as $user)
<tr>
<td>{{ $user->name }}</td>
<td>{{ $user->email }}</td>
<td><span class="badge bg-secondary">{{ $user->getRoleNames()->first() ?? 'none' }}</span></td>
<td class="text-end">
<form method="POST" action="{{ route('users.update', $user) }}" class="d-inline-flex gap-2">
@csrf
@method('PATCH')
<select name="role" class="form-select form-select-sm">
@foreach ($roles as $role)
<option value="{{ $role }}" @selected($user->hasRole($role))>{{ ucfirst($role) }}</option>
@endforeach
</select>
<button type="submit" class="btn btn-sm btn-outline-primary">Save</button>
</form>
</td>
</tr>
@endforeach
</tbody>
</table>
{{ $users->links() }}
@endsection