<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseRegistration;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class StudentPortalController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view available courses', only: ['available']),
            new Middleware('permission:register for courses', only: ['register']),
            new Middleware('permission:view own registrations', only: ['registrations', 'drop']),
        ];
    }

    public function available(Request $request)
    {
        $student = $request->user()->student;
        $registeredIds = $student
            ? $student->courses()->pluck('courses.id')->all()
            : [];
        $courses = Course::with('lecturer')->orderBy('code')->get();

        return view('portal.available', compact('courses', 'registeredIds', 'student'));
    }

    public function register(Request $request, Course $course)
    {
        $request->validate([
            'academic_year' => ['required', 'in:2026/2027'],
        ]);

        $student = $request->user()->student;

        if (! $student) {
            return back()->with('error', 'Your account has no student profile yet. Please contact the administrator.');
        }

        // duplicate registration prevention
        if ($student->courses()->where('courses.id', $course->id)->exists()) {
            return back()->with('error', 'You are already registered for ' . $course->code . '.');
        }

        $student->courses()->attach($course->id, [
            'academic_year' => $request->academic_year,
            'status' => 'registered',
        ]);

        return redirect()->route('portal.registrations')
            ->with('success', 'You have registered for ' . $course->code . ' - ' . $course->title . '.');
    }

    // only the logged-in student's own registrations
    public function registrations(Request $request)
    {
        $student = $request->user()->student;
        $registrations = $student
            ? $student->registrations()->with('course.lecturer')->latest('id')->get()
            : collect();

        return view('portal.registrations', compact('registrations', 'student'));
    }

    public function drop(Request $request, CourseRegistration $registration)
    {
        // a student can only remove their own registration
        abort_unless($registration->student_id === $request->user()->student?->id, 403);

        $registration->delete();

        return redirect()->route('portal.registrations')
            ->with('success', 'Registration removed.');
    }
}