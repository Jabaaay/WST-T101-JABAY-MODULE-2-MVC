<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\User;


class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with('user')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
    return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('students.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|unique:students',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'required',
            'phone_number' => 'required',
            'year_level' => 'required|integer|between:1,4',
            'section' => 'required|string|in:BSIT,BSAT,BSFT,BSET',
        ]);

        // Create user account with default password
        $user = User::create([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'password' => bcrypt('password'), // Default password is 'password'
            'role' => 'student'
        ]);

        // Create student record
        $student = new Student([
            'student_id' => $validated['student_id'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'date_of_birth' => $validated['date_of_birth'],
            'gender' => $validated['gender'],
            'address' => $validated['address'],
            'phone_number' => $validated['phone_number'],
            'year_level' => $validated['year_level'],
            'section' => $validated['section']
        ]);

        $student->user()->associate($user);
        $student->save();

        return redirect()->route('students.index')
            ->with('success', 'Student created successfully. Default password is: password');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'student_id' => 'required|unique:students,student_id,' . $student->id,
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,' . $student->user->id,
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'required',
            'phone_number' => 'required',
            'year_level' => 'required|integer|between:1,4',
            'section' => 'required|string|in:BSIT,BSAT,BSFT,BSET',
        ]);

        // Update student record
        $student->update([
            'student_id' => $validated['student_id'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'date_of_birth' => $validated['date_of_birth'],
            'gender' => $validated['gender'],
            'address' => $validated['address'],
            'phone_number' => $validated['phone_number'],
            'year_level' => $validated['year_level'],
            'section' => $validated['section']
        ]);

        // Update associated user's name and email
        if ($student->user) {
            $student->user->update([
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email']
            ]);
        }

        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        // Delete associated user account
        if ($student->user) {
            $student->user->delete();
        }
        
        $student->delete();
        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }
}
