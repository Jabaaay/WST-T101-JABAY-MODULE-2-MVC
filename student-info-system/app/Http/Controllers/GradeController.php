<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;


class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grades = Grade::with(['enrollment.student', 'enrollment.subject'])->get();
        return view('grades.index', compact('grades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $enrollments = Enrollment::with(['student', 'subject'])
            ->where('status', 'enrolled')
            ->get();
        return view('grades.create', compact('enrollments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
            'score' => 'required|numeric|between:0,100'
        ]);

        // Check if grade already exists for this enrollment
        $exists = Grade::where('enrollment_id', $validated['enrollment_id'])->exists();
        if ($exists) {
            return back()->withErrors(['error' => 'A grade already exists for this enrollment.'])
                        ->withInput();
        }

        // Convert percentage score to grade point
        $gradePoint = $this->convertToGradePoint($validated['score']);

        Grade::create([
            'enrollment_id' => $validated['enrollment_id'],
            'grade' => $gradePoint,
            'score' => $validated['score']
          
        ]);

        return redirect()->route('grades.index')
            ->with('success', 'Grade recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Grade $grade)
    {
        return view('grades.show', compact('grade'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Grade $grade)
    {
        $grade->load('enrollment.student', 'enrollment.subject');
        return view('grades.edit', compact('grade'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Grade $grade)
    {
        $validated = $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
            'score' => 'required|numeric|between:0,100'
        
        ]);

        // Convert percentage score to grade point
        $gradePoint = $this->convertToGradePoint($validated['score']);

        $grade->update([
            'enrollment_id' => $validated['enrollment_id'],
            'grade' => $gradePoint,
            'score' => $validated['score']
        ]);

        return redirect()->route('grades.index')
            ->with('success', 'Grade updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grade $grade)
    {
        {
            $grade->delete();
            return redirect()->route('grades.index')
                ->with('success', 'Grade deleted successfully.');
        }
    }
    private function convertToGradePoint($score)
    {
        if ($score >= 97) return 1.0;
        if ($score >= 94) return 1.25;
        if ($score >= 91) return 1.5;
        if ($score >= 88) return 1.75;
        if ($score >= 85) return 2.0;
        if ($score >= 82) return 2.25;
        if ($score >= 79) return 2.5;
        if ($score >= 76) return 2.75;
        if ($score >= 75) return 3.0;
        return 5.0; // Failed
    }
}
