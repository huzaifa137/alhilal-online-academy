<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    protected $table = 'exam_results';
    
    protected $fillable = [
        'exam_id',
        'student_id',
        'exam_attempt_id',
        'score',
        'percentage',
        'is_passed',
        'attempt_number',
        'answers',
        'started_at',
        'completed_at'
    ];
    
    protected $casts = [
        'answers' => 'array',
        'is_passed' => 'boolean',
        'score' => 'decimal:2',
        'percentage' => 'decimal:2'
    ];
    
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
    
    public function student()
    {
        return $this->belongsTo(\App\Models\User::class, 'student_id');
    }
    
    public function attempt()
    {
        return $this->belongsTo(ExamAttempt::class, 'exam_attempt_id');
    }
}