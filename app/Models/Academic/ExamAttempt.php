<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Model;

class ExamAttempt extends Model
{
    protected $table = 'exam_attempts';
    
    protected $fillable = [
        'exam_id',
        'student_id',
        'started_at',
        'submitted_at',
        'time_spent_seconds',
        'marks_obtained',
        'percentage',
        'is_passed',
        'status',
        'teacher_feedback',
        'graded_by',
        'graded_at'
    ];
    
    protected $casts = [
        'is_passed' => 'boolean',
        'marks_obtained' => 'decimal:2',
        'percentage' => 'decimal:2',
        'started_at' => 'datetime',
        'submitted_at' => 'datetime',
        'graded_at' => 'datetime'
    ];
    
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
    
    public function student()
    {
        return $this->belongsTo(\App\Models\User::class, 'student_id');
    }
    
    public function results()
    {
        return $this->hasMany(ExamResult::class, 'exam_attempt_id');
    }
}