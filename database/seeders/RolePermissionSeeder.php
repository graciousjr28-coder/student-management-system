<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'view students',
            'create students',
            'edit students',
            'delete students',

            'view courses',
            'create courses',
            'edit courses',
            'delete courses',

            'view all registrations',
            'manage registrations',

            'manage users',

            'view assigned courses',

            'view available courses',
            'register for courses',
            'view own registrations',
        ];

        foreach ($permissions as $name) {
            Permission::firstOrCreate([
                'name' => $name,
                'guard_name' => 'web'
            ]);
        }

        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

        $admin->syncPermissions(
            Permission::whereNotIn('name', [
                'view assigned courses',
                'view available courses',
                'register for courses',
                'view own registrations',
            ])->get()
        );

        $lecturer = Role::firstOrCreate([
            'name' => 'lecturer',
            'guard_name' => 'web'
        ]);

        $lecturer->syncPermissions([
            'view assigned courses'
        ]);

        $student = Role::firstOrCreate([
            'name' => 'student',
            'guard_name' => 'web'
        ]);

        $student->syncPermissions([
            'view available courses',
            'register for courses',
            'view own registrations',
        ]);
    }
}