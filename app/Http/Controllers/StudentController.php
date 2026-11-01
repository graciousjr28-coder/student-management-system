<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StudentController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view students', only: ['index', 'show']),
            new Middleware('permission:create students', only: ['create', 'store']),
            new Middleware('permission:edit students', only: ['edit', 'update']),
            new Middleware('permission:delete students', only: ['destroy']),
        ];
    }

    public function index()
    {
        $students = Student::withCount('courses')
            ->orderBy('student_number')
            ->paginate(10);

        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'     => ['required', 'string', 'max:100'],
            'last_name'      => ['required', 'string', 'max:100'],
            'email'          => ['required', 'email', 'max:255', 'unique:users,email'],
            'student_number' => ['required', 'string', 'max:50', 'unique:students,student_number'],
            'phone'          => ['nullable', 'string', 'max:20'],
            'programme'      => ['required', 'string', 'max:150'],
            'year_of_study'  => ['required', 'integer', 'between:1,4'],
            'password'       => ['nullable', 'string', 'min:8'],
        ]);

        DB::transaction(function () use ($data) {
            $user = User::create([
                'name'     => $data['first_name'] . ' ' . $data['last_name'],
                'email'    => $data['email'],
                'password' => $data['password'] ?? 'password',
            ]);
            $user->assignRole('student');

            Student::create([
                'user_id'        => $user->id,
                'student_number' => $data['student_number'],
                'first_name'     => $data['first_name'],
                'last_name'      => $data['last_name'],
                'phone'          => $data['phone'] ?? null,
                'programme'      => $data['programme'],
                'year_of_study'  => $data['year_of_study'],
            ]);
        });

        return redirect()->route('students.index')
            ->with('success', 'Student added successfully.');
    }

    public function show(Student $student)
    {
        // Q1c: the courses this student is registered for
        $student->load('user', 'courses.lecturer');

        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $student->load('user');

        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $user = $student->user;

        $data = $request->validate([
            'first_name'     => ['required', 'string', 'max:100'],
            'last_name'      => ['required', 'string', 'max:100'],
            'email'          => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user?->id)],
            'student_number' => ['required', 'string', 'max:50', Rule::unique('students', 'student_number')->ignore($student->id)],
            'phone'          => ['nullable', 'string', 'max:20'],
            'programme'      => ['required', 'string', 'max:150'],
            'year_of_study'  => ['required', 'integer', 'between:1,4'],
            'password'       => ['nullable', 'string', 'min:8'],
        ]);

        DB::transaction(function () use ($data, $student, $user) {
            $student->update([
                'student_number' => $data['student_number'],
                'first_name'     => $data['first_name'],
                'last_name'      => $data['last_name'],
                'phone'          => $data['phone'] ?? null,
                'programme'      => $data['programme'],
                'year_of_study'  => $data['year_of_study'],
            ]);

            if ($user) {
                $user->name  = $data['first_name'] . ' ' . $data['last_name'];
                $user->email = $data['email'];
                if (! empty($data['password'])) {
                    $user->password = $data['password'];
                }
                $user->save();
            }
        });

        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        DB::transaction(function () use ($student) {
            $user = $student->user;
            $student->delete(); // registrations are removed by the cascade
            $user?->delete();
        });

        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }
}