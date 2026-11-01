<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            [
                'first' => 'Amina',
                'last' => 'Nakato',
                'email' => 'amina@sms.test',
                'number' => '2024/BUC/001',
                'phone' => '0700000001',
                'year' => 3
            ],
            [
                'first' => 'Joseph',
                'last' => 'Opio',
                'email' => 'joseph@sms.test',
                'number' => '2024/BUC/002',
                'phone' => '0700000002',
                'year' => 3
            ],
            [
                'first' => 'Esther',
                'last' => 'Atim',
                'email' => 'esther@sms.test',
                'number' => '2024/BUC/003',
                'phone' => '0700000003',
                'year' => 2
            ],
            [
                'first' => 'Daniel',
                'last' => 'Mugisha',
                'email' => 'daniel@sms.test',
                'number' => '2024/BUC/004',
                'phone' => '0700000004',
                'year' => 2
            ],
            [
                'first' => 'Faith',
                'last' => 'Akello',
                'email' => 'faith@sms.test',
                'number' => '2024/BUC/005',
                'phone' => '0700000005',
                'year' => 1
            ],
            [
                'first' => 'Samuel',
                'last' => 'Kato',
                'email' => 'samuel@sms.test',
                'number' => '2024/BUC/006',
                'phone' => '0700000006',
                'year' => 1
            ],
        ];

        foreach ($students as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['first'] . ' ' . $data['last'],
                    'password' => 'password'
                ]
            );

            $user->syncRoles('student');

            Student::updateOrCreate(
                ['student_number' => $data['number']],
                [
                    'user_id' => $user->id,
                    'first_name' => $data['first'],
                    'last_name' => $data['last'],
                    'phone' => $data['phone'],
                    'programme' => 'Bachelor of Business Computing',
                    'year_of_study' => $data['year'],
                ]
            );
        }
    }
}