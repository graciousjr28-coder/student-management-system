<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@sms.test'],
            [
                'name' => 'System Administrator',
                'password' => 'password'
            ]
        );

        $admin->syncRoles('admin');

        $lecturers = [
            [
                'name' => 'Dr. Grace Namuli',
                'email' => 'grace@sms.test'
            ],
            [
                'name' => 'Mr. Peter Ssemakula',
                'email' => 'peter@sms.test'
            ],
            [
                'name' => 'Ms. Rebecca Auma',
                'email' => 'rebecca@sms.test'
            ],
        ];

        foreach ($lecturers as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => 'password'
                ]
            );

            $user->syncRoles('lecturer');
        }
    }
}