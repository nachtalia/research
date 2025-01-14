<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Ensure it extends Authenticatable
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use HasFactory, Notifiable; // Added Notifiable for sending notifications (if needed)

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['lrn', 'student_name', 'section_id', 'password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Override the column used for authentication (LRN instead of email).
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'lrn';
    }

    /**
     * Define the relationship with the Section model.
     */
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * Define the relationship with the Grade model.
     */
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    /**
     * Define the relationship with the AverageGrade model.
     */
    public function averageGrades()
    {
        return $this->hasMany(AverageGrade::class);
    }
}
