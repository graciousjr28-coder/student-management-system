<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Validation\Rule;

class CourseController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view courses', only: ['index', 'show']),
            new Middleware('permission:create courses', only: ['create', 'store']),
            new Middleware('permission:edit courses', only: ['edit', 'update']),
            new Middleware('permission:delete courses', only: ['destroy']),
        ];
    }

    public function index()
    {
        $courses = Course::with('lecturer')
            ->withCount('students')
            ->orderBy('code')
            ->paginate(10);

        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        $lecturers = User::role('lecturer')->orderBy('name')->get();

        return view('courses.create', compact('lecturers'));
    }

    public function store(Request $request)
    {
        Course::create($this->validated($request));

        return redirect()->route('courses.index')
            ->with('success', 'Course added successfully.');
    }

    public function show(Course $course)
    {
        // Q1c: the students registered for this course
        $course->load('lecturer', 'students');

        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $lecturers = User::role('lecturer')->orderBy('name')->get();

        return view('courses.edit', compact('course', 'lecturers'));
    }

    public function update(Request $request, Course $course)
    {
        $course->update($this->validated($request, $course));

        return redirect()->route('courses.index')
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete(); // its registrations are removed by the cascade

        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully.');
    }

    private function validated(Request $request, ?Course $course = null): array
    {
        return $request->validate([
            'code'         => ['required', 'string', 'max:20', Rule::unique('courses', 'code')->ignore($course?->id)],
            'title'        => ['required', 'string', 'max:255'],
            'description'  => ['nullable', 'string', 'max:2000'],
            'credit_units' => ['required', 'integer', 'between:1,10'],
            'lecturer_id'  => ['nullable', Rule::in(User::role('lecturer')->pluck('id')->all())],
        ]);
    }
}