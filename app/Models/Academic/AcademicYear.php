<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * (Optional, Laravel can infer this automatically)
     */
    protected $table = 'academic_years';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'is_current',
        'status',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
    ];

    /**
     * Scope to get the current academic year.
     */
    public function scopeCurrent($query)
    {
        return $query->where('is_current', true);
    }

    /**
     * Optional: relationships
     * Example: an academic year can have many classes
     */
    // public function classes()
    // {
    //     return $this->hasMany(SchoolClass::class);
    // }
}