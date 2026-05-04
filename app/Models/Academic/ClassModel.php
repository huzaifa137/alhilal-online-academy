<?php

namespace App\Models\Academic;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassModel extends Model
{
    protected $table = 'classes';

    protected $fillable = [
        'level_id',
        'academic_year_id',
        'name',
        'code',
        'class_teacher_id',
        'capacity',
        'room_number',
        'description',
        'status'
    ];

    protected $casts = [
        'status' => 'string',
    ];

    // Relationships
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function classTeacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'class_teacher_id');
    }

    // FIXED: Specify the foreign key explicitly
    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'class_subjects', 'class_id', 'subject_id')
            ->withPivot(['teacher_id', 'periods_per_week', 'is_compulsory', 'passing_marks', 'full_marks'])
            ->withTimestamps();
    }

    // FIXED: Specify the foreign key explicitly
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'class_students', 'class_id', 'user_id')
            ->withPivot(['enrollment_date', 'status', 'roll_number'])
            ->withTimestamps();
    }

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class, 'class_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByLevel($query, $levelId)
    {
        return $query->where('level_id', $levelId);
    }

    public function scopeByAcademicYear($query, $yearId)
    {
        return $query->where('academic_year_id', $yearId);
    }

    public function scopeCurrentAcademicYear($query)
    {
        return $query->whereHas('academicYear', fn($q) => $q->where('is_current', true));
    }
}