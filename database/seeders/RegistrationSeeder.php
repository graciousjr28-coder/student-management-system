<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Seeder;

class RegistrationSeeder extends Seeder
{
    public function run(): void
    {
        $plan = [
            '2024/BUC/001' => ['CSC101', 'CSC202', 'CSC305'],
            '2024/BUC/002' => ['CSC101', 'BUS210'],
            '2024/BUC/003' => ['CSC202', 'CSC305', 'CSC310'],
            '2024/BUC/004' => ['CSC101', 'CSC310'],
            '2024/BUC/005' => ['BUS210', 'CSC305'],
            '2024/BUC/006' => ['CSC202', 'BUS210', 'CSC101'],
        ];

        foreach ($plan as $studentNumber => $codes) {
            $student = Student::where(
                'student_number',
                $studentNumber
            )->first();

            if (! $student) {
                continue;
            }

            $sync = [];

            foreach (Course::whereIn('code', $codes)->pluck('id') as $courseId) {
                $sync[$courseId] = [
                    'academic_year' => '2026/2027',
                    'status' => 'registered'
                ];
            }

            $student->courses()->syncWithoutDetaching($sync);
        }
    }
}