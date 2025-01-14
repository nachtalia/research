<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{
    /**
     * Fetch all students (visible to teachers)
     */
    public function index()
    {
        $students = Student::all(); // You can filter by teacher, if needed
        return Inertia::render('Dashboard', [
            'students' => $students,
        ]);
    }

    /**
     * Create a new student (can be managed by teacher)
     */
    public function store(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'lrn' => 'required|unique:students,lrn|numeric',
            'student_name' => 'required|string|max:255',
            'section_id' => 'required|exists:sections,id',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create student
        $student = Student::create($validated);

        // Return response
        return redirect()->route('students.index')->with('success', 'Student created successfully!');
    }

    /**
     * Update student information
     */
    public function update(Request $request, $id)
    {
        // Validation
        $validated = $request->validate([
            'lrn' => 'required|numeric|unique:students,lrn,' . $id,
            'student_name' => 'required|string|max:255',
            'section_id' => 'required|exists:sections,id',
        ]);

        // Find and update the student
        $student = Student::findOrFail($id); // Using findOrFail instead of find for better error handling
        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Student updated successfully!');
    }

    /**
     * Delete a student
     */
    public function destroy($id)
    {
        // Find and delete the student
        $student = Student::findOrFail($id); // Using findOrFail for error handling
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
    }
}
