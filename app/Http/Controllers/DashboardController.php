<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $stats = [];

        if ($user->hasRole('admin')) {
            $stats = [
                ['label' => 'Students', 'value' => Student::count()],
                ['label' => 'Courses', 'value' => Course::count()],
                ['label' => 'Lecturers', 'value' => User::role('lecturer')->count()],
                ['label' => 'Registrations', 'value' => CourseRegistration::count()],
            ];
        } elseif ($user->hasRole('lecturer')) {
            $courseIds = $user->courses()->pluck('id');
            $stats = [
                ['label' => 'My courses', 'value' => $courseIds->count()],
                ['label' => 'Student registrations', 'value' => CourseRegistration::whereIn('course_id', $courseIds)->count()],
            ];
        } elseif ($user->hasRole('student')) {
            $registered = $user->student ? $user->student->courses()->count() : 0;
            $stats = [
                ['label' => 'My registrations', 'value' => $registered],
                ['label' => 'Courses still open to me', 'value' => max(Course::count() - $registered, 0)],
            ];
        }

        return view('dashboard', compact('stats'));
    }
}