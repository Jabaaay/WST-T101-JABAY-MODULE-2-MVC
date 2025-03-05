<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Enrollment;
use App\Models\Grade;

class DashboardController extends Controller
{
    public function index()
    {
        $studentsCount = Student::count();
        $subjectsCount = Subject::count();
        $enrollmentsCount = Enrollment::count();
        $gradesCount = Grade::count();

        // Get student count per section
        $sectionCounts = Student::selectRaw('section, COUNT(*) as count')
            ->groupBy('section')
            ->pluck('count', 'section')
            ->toArray();

        // Get student count per year level
        $yearCounts = Student::selectRaw('year_level, COUNT(*) as count')
            ->groupBy('year_level')
            ->pluck('count', 'year_level')
            ->toArray();

        return view('dashboard', compact(
            'studentsCount', 'subjectsCount', 'enrollmentsCount', 'gradesCount', 
            'sectionCounts', 'yearCounts'
        ));
    }
}

