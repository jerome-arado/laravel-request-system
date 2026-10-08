<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Student A
        User::updateOrCreate(
            ['email' => 'student.a@example.test'],
            [
                'name'     => 'Student A',
                'password' => Hash::make('Password123!'),
                'is_admin' => false,
            ]
        );

        // Student B
        User::updateOrCreate(
            ['email' => 'student.b@example.test'],
            [
                'name'     => 'Student B',
                'password' => Hash::make('Password123!'),
                'is_admin' => false,
            ]
        );

        // Administrator
        User::updateOrCreate(
            ['email' => 'admin@example.test'],
            [
                'name'     => 'Administrator',
                'password' => Hash::make('AdminPass123!'),
                'is_admin' => true,
            ]
        );
    }
}