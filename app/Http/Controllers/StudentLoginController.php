<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentLoginController extends Controller
{
    /**
     * Display the login form.
     */
    public function index()
    {
        return inertia('Auth/studentlogin');
    }

    /**
     * Handle student login.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'lrn' => 'required|exists:students,lrn', // Ensure LRN exists in the students table
        ]);

        // Find the student by LRN
        $student = Student::where('lrn', $request->lrn)->first();

        if ($student) {
            // Log the student in manually by setting session data
            session(['student' => $student]); // Store the student in the session

            // Redirect to the student's dashboard or intended page
            return redirect()->intended('/dashboard');
        }

        // Authentication failed, redirect back with errors
        return back()->withErrors(['lrn' => 'Invalid LRN'])->onlyInput('lrn');
    }
}
