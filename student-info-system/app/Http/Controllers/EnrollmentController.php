<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Subject;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $enrollments = Enrollment::with(['student', 'subject'])->get();
        return view('enrollments.index', compact('enrollments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::all();
        $subjects = Subject::all();
        return view('enrollments.create', compact('students', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'academic_year' => 'required|string',
            'semester' => 'required|in:First,Second,Summer',
            'status' => 'required|in:enrolled,pending,dropped'
        ]);

        // Check if student is already enrolled in this subject for the same academic year and semester
        $exists = Enrollment::where('student_id', $validated['student_id'])
            ->where('subject_id', $validated['subject_id'])
            ->where('academic_year', $validated['academic_year'])
            ->where('semester', $validated['semester'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['error' => 'Student is already enrolled in this subject for the selected academic year and semester.'])
                        ->withInput();
        }

        Enrollment::create($validated);

        return redirect()->route('enrollments.index')
            ->with('success', 'Enrollment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Enrollment $enrollment)
    {
        return view('enrollments.show', compact('enrollment'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enrollment $enrollment)
    {
        $students = Student::all();
        $subjects = Subject::all();
        return view('enrollments.edit', compact('enrollment', 'students', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Enrollment $enrollment)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'student_id' => 'required|exists:students,id',
                'subject_id' => 'required|exists:subjects,id',
                'academic_year' => 'required|string',
                'semester' => 'required|in:First,Second,Summer',
                'status' => 'required|in:enrolled,pending,dropped'
            ]);

            // Check if another enrollment exists for the same student, subject, academic year, and semester
            $exists = Enrollment::where('student_id', $validated['student_id'])
                ->where('subject_id', $validated['subject_id'])
                ->where('academic_year', $validated['academic_year'])
                ->where('semester', $validated['semester'])
                ->where('id', '!=', $enrollment->id)
                ->exists();

            if ($exists) {
                DB::rollBack();
                return back()->withErrors(['error' => 'Student is already enrolled in this subject for the selected academic year and semester.'])
                            ->withInput();
            }

            // Update all fields including status
            $enrollment->update($validated);

            DB::commit();
            return redirect()->route('enrollments.index')
                ->with('success', 'Enrollment updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'An error occurred while updating the enrollment: ' . $e->getMessage()])
                        ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        return redirect()->route('enrollments.index')
            ->with('success', 'Enrollment deleted successfully.');
    }

    public function showMySubjects()
    {
        $enrollments = Enrollment::where('student_id', auth()->user()->student->id)
            ->with('subject')
            ->get();
        
        return view('enrollments.my-subjects', compact('enrollments'));
    }
}
