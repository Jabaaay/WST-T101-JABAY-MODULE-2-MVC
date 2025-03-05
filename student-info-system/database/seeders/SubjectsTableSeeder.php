<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subject;


class SubjectsTableSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            [
                'subject_code' => 'GE 109A',
                'name' => 'The Life and Works of Rizal',
                'description' => 'Exploration of Jose Rizal’s biography, literary works, and contributions to Philippine nationalism.',
                'credits' => 3.0
            ],
            [
                'subject_code' => 'GE EL 102',
                'name' => 'Gender and Society',
                'description' => 'Analysis of gender roles, identities, and their influence on societal structures and interactions.',
                'credits' => 3.0
            ],
            [
                'subject_code' => 'IS 106B',
                'name' => 'ASEAN Studies',
                'description' => 'Comprehensive study of ASEAN history, policies, economic integration, and diplomatic relations.',
                'credits' => 3.0
            ],
            [
                'subject_code' => 'IT 138C',
                'name' => 'Information Assurance and Security 2',
                'description' => 'Advanced principles and strategies in cybersecurity, risk management, and data protection.',
                'credits' => 3.0
            ],
            [
                'subject_code' => 'IT 139A',
                'name' => 'Elective 4 - Systems Integration and Architecture 2',
                'description' => 'Study of system integration methodologies and the implementation of GIS technologies.',
                'credits' => 3.0
            ],
            [
                'subject_code' => 'IT- 1310',
                'name' => 'Application Development and Emerging Technologies',
                'description' => 'Exploration of modern application development frameworks and emerging technology trends.',
                'credits' => 3.0
            ],
            [
                'subject_code' => 'IT 1311A',
                'name' => 'Multimedia Systems',
                'description' => 'Development, integration, and application of multimedia technologies in digital platforms.',
                'credits' => 3.0
            ],
            [
                'subject_code' => 'IT 1312',
                'name' => 'Capstone Project and Research 2',
                'description' => 'Implementation, documentation, and presentation of a final year research or development project.',
                'credits' => 3.0
            ],
            [
                'subject_code' => 'IT 1313',
                'name' => 'Elective 5: Web Systems and Technologies',
                'description' => 'Advanced concepts in web development, including frameworks, cloud integration, and security.',
                'credits' => 3.0
            ],
            
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}
