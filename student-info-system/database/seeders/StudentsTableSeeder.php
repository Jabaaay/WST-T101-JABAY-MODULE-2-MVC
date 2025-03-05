<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\User;
use Faker\Factory as Faker;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $studentUsers = User::where('role', 'student')->get();
        
        foreach ($studentUsers as $user) {
            $studentId = 'ID' . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT);
            
            Student::create([
                'user_id' => $user->id,
                'student_id' => $studentId,
                'first_name' => explode(' ', $user->name)[0],
                'last_name' => isset(explode(' ', $user->name)[1]) ? explode(' ', $user->name)[1] : 'LastName',
                'email' => $user->email,
                'date_of_birth' => $faker->date('Y-m-d', '2005-12-31'),
                'gender' => $faker->randomElement(['male', 'female']),
                'address' => $faker->address,
                'phone_number' => $faker->phoneNumber,
                'year_level' => $faker->randomElement([1, 2, 3, 4]),
                'section' => $faker->randomElement(['BSIT', 'BSAT', 'BSFT', 'BSET']),
            ]);
            
        }
    }
}
