<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Teacher;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'teacher_id' => 'required|string|max:255|unique:teachers,teacher_id', // Ensure teacher_id is unique in the teachers table
            'teacher_name' => 'required|string|max:255', // teacher_name must be a string and required
            'password' => ['required', 'confirmed', Rules\Password::defaults()], // Password validation with confirmation
        ]);
    
        // Create a new teacher record in the database
        Teacher::create([
            'teacher_id' => $request->teacher_id,
            'teacher_name' => $request->teacher_name,
            'password' => bcrypt($request->password), // Hashing the password before storing
        ]);

        return redirect()->route('dashboard');
    }
}
