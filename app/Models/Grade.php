<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id',
        'subject_id',
        'teacher_id',
        'first_period',
        'second_period',
        'third_period',
        'fourth_period'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'first_period' => 'float',
        'second_period' => 'float',
        'third_period' => 'float',
        'fourth_period' => 'float',
    ];

    /**
     * Define the relationship with the Student model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Define the relationship with the Subject model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Define the relationship with the Teacher model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Define the relationship with the PeriodGrade model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function periodGrades()
    {
        return $this->hasMany(PeriodGrade::class);
    }

    /**
     * Calculate the average grade across all periods.
     *
     * @return float|null
     */
    public function calculateAverage(): ?float
    {
        $grades = array_filter([
            $this->first_period,
            $this->second_period,
            $this->third_period,
            $this->fourth_period,
        ]);

        if (empty($grades)) {
            return null; // Return null if no grades are present
        }

        return round(array_sum($grades) / count($grades), 2);
    }
}
