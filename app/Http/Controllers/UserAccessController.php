<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Validation\Rule;

class UserAccessController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:manage users'),
        ];
    }

    public function index()
    {
        $users = User::with('roles')->orderBy('name')->paginate(15);
        $roles = ['admin', 'lecturer', 'student'];

        return view('users.index', compact('users', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => ['required', Rule::in(['admin', 'lecturer', 'student'])],
        ]);

        // stop the administrator from removing their own admin role
        if ($user->id === $request->user()->id) {
            return back()->with('error', 'You cannot change your own role.');
        }

        $user->syncRoles($data['role']);

        return back()->with('success', 'Role updated for ' . $user->name . '.');
    }
}