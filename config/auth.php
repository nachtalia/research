<?php

return [

/*
|----------------------------------------------------------------------
| Authentication Defaults
|----------------------------------------------------------------------
|
| This option defines the default authentication "guard" and password
| reset "broker" for your application. You may change these values
| as required, but they're a perfect start for most applications.
|
*/

'defaults' => [
    'guard' => env('AUTH_GUARD', 'web'), // Default guard can still be 'web' for teachers
    'passwords' => 'teachers', // Ensure the password broker matches the teachers' provider
],

/*
|----------------------------------------------------------------------
| Authentication Guards
|----------------------------------------------------------------------
|
| Here you define every authentication guard for your application.
| We will add a new 'student' guard while keeping the 'web' for teachers.
|
*/

'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'teachers', // Guard for teacher authentication
    ],
    'student' => [  // New guard for student login
        'driver' => 'session',
        'provider' => 'students', // Provider for student authentication
    ],
],

/*
|----------------------------------------------------------------------
| User Providers
|----------------------------------------------------------------------
|
| All authentication guards have a user provider. Here we define a provider
| for both teachers and students. The student provider is added below.
|
*/

'providers' => [
    'teachers' => [
        'driver' => 'eloquent',
        'model' => App\Models\Teacher::class, // Updated to use the Teacher model
    ],
    'students' => [  // New provider for students
        'driver' => 'eloquent',
        'model' => App\Models\Student::class, // Use the Student model for the students table
        'query' => function($query) {
            return $query->whereNotNull('lrn'); // Ensure 'lrn' exists for students
        }
    ],
],

/*
|----------------------------------------------------------------------
| Resetting Passwords
|----------------------------------------------------------------------
|
| The following configuration options specify the behavior of Laravel's
| password reset functionality. We will add the 'students' reset table.
|
*/

'passwords' => [
    'teachers' => [
        'provider' => 'teachers', // Matches the teachers provider
        'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
        'expire' => 60,
        'throttle' => 60,
    ],

    // No password reset configuration for students, as students do not use passwords
],

/*
|----------------------------------------------------------------------
| Password Confirmation Timeout
|----------------------------------------------------------------------
|
| Here you may define the amount of seconds before a password confirmation
| window expires and users are asked to re-enter their password via the
| confirmation screen. By default, the timeout lasts for three hours.
|
*/

'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
