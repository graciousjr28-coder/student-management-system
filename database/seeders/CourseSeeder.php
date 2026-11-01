<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $grace = User::where('email', 'grace@sms.test')->first();
        $peter = User::where('email', 'peter@sms.test')->first();
        $rebecca = User::where('email', 'rebecca@sms.test')->first();

        $courses = [
            [
                'code' => 'CSC101',
                'title' => 'Introduction to Programming',
                'description' => 'Programming basics with PHP.',
                'credit_units' => 4,
                'lecturer_id' => $grace?->id
            ],
            [
                'code' => 'CSC202',
                'title' => 'Database Systems',
                'description' => 'Relational design and SQL.',
                'credit_units' => 4,
                'lecturer_id' => $peter?->id
            ],
            [
                'code' => 'CSC305',
                'title' => 'Web Application Development',
                'description' => 'Full-stack development with Laravel.',
                'credit_units' => 4,
                'lecturer_id' => $grace?->id
            ],
            [
                'code' => 'BUS210',
                'title' => 'Business Communication',
                'description' => 'Professional writing and presentation.',
                'credit_units' => 3,
                'lecturer_id' => $rebecca?->id
            ],
            [
                'code' => 'CSC310',
                'title' => 'Systems Analysis and Design',
                'description' => 'Requirements, modelling and design.',
                'credit_units' => 3,
                'lecturer_id' => $peter?->id
            ],
        ];

        foreach ($courses as $data) {
            Course::updateOrCreate(
                ['code' => $data['code']],
                $data
            );
        }
    }
}