<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;




class UsersTablesSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Create a demo student user
        User::create([
            'name' => 'Student User',
            'email' => 'student@example.com',
            'password' => Hash::make('student123'),
            'role' => 'student',
        ]);

        $faker = Faker::create();

        // Create 50 student users
        for ($i = 1; $i <= 50; $i++) {
            User::create([
                'name' => $faker->firstName . ' ' . $faker->lastName, // Generates a random full name
                'email' => "student{$i}@example.com",
                'password' => Hash::make('password123'),
                'role' => 'student',
            ]);
        }
    }
}
