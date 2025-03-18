<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\Grade;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profile()
    {
        $student = Student::where('user_id', Auth::id())->firstOrFail();
        return view('student.profile', compact('student'));
    }

    public function enrollments()
    {
        $student = Student::where('user_id', Auth::id())->firstOrFail();
        $enrollments = $student->enrollments()->with('subject')->get();
        return view('student.enrollments', compact('enrollments'));
    }

    public function grades()
{
    $student = Student::where('user_id', Auth::id())->firstOrFail();
    $grades = Grade::whereHas('enrollment', function($query) use ($student) {
        $query->where('student_id', $student->id);
    })->with(['enrollment.subject'])->get();

    // Calculate the GWA (General Weighted Average)
    $totalGrades = 0;
    $totalSubjects = count($grades);

    foreach ($grades as $grade) {
        $totalGrades += $grade->grade;  // Assuming 'grade' is the column in the Grade model
    }

    $gwa = $totalSubjects > 0 ? $totalGrades / $totalSubjects : 0;

    return view('student.grades', compact('grades', 'gwa'));
}

}
