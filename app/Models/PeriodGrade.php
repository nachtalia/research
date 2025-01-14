<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodGrade extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['grade_id', 'period', 'grade'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'grade' => 'float', // Ensure grade is always treated as a float
    ];

    /**
     * Define the relationship with the Grade model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
}
