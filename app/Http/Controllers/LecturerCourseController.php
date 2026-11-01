<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class LecturerCourseController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view assigned courses'),
        ];
    }

    // only the courses assigned to the logged-in lecturer
    public function index(Request $request)
    {
        $courses = $request->user()
            ->courses()
            ->withCount('students')
            ->orderBy('code')
            ->get();

        return view('lecturer.index', compact('courses'));
    }

    public function show(Request $request, Course $course)
    {
        // a lecturer cannot open another lecturer's course
        abort_unless($course->lecturer_id === $request->user()->id, 403);

        $course->load('students');

        return view('lecturer.show', compact('course'));
    }
}