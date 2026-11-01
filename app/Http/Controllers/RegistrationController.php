<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Validation\Rule;

class RegistrationController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view all registrations', only: ['index']),
            new Middleware('permission:manage registrations', only: ['create', 'store', 'destroy']),
        ];
    }

    public function index()
    {
        $registrations = CourseRegistration::with(['student', 'course'])
            ->latest('id')
            ->paginate(10);

        return view('registrations.index', compact('registrations'));
    }

    public function create()
    {
        $students = Student::orderBy('student_number')->get();
        $courses = Course::orderBy('code')->get();

        return view('registrations.create', compact('students', 'courses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'course_id' => [
                'required',
                'exists:courses,id',
                // block a duplicate registration for the same student and course
                Rule::unique('course_registrations', 'course_id')
                    ->where(fn ($query) => $query->where('student_id', $request->student_id)),
            ],
            'academic_year' => ['required', 'string', 'max:20'],
        ], [
            'course_id.unique' => 'This student is already registered for that course.',
        ]);

        CourseRegistration::create([
            'student_id' => $data['student_id'],
            'course_id' => $data['course_id'],
            'academic_year' => $data['academic_year'],
            'status' => 'registered',
        ]);

        return redirect()->route('registrations.index')
            ->with('success', 'Registration added successfully.');
    }

    public function destroy(CourseRegistration $registration)
    {
        $registration->delete();

        return redirect()->route('registrations.index')
            ->with('success', 'Registration removed successfully.');
    }
}