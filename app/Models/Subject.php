<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['subject_name'];

    /**
     * The relationship with the Grade model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    /**
     * The relationship with the AverageGrade model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function averageGrades()
    {
        return $this->hasMany(AverageGrade::class);
    }
}
