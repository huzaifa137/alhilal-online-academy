<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'exam_id',
        'score',
        'percentage',
        'honors_classification',
        'completed_at',
        'duration_taken',
        'is_passed'
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'is_passed' => 'boolean'
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Exam
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    // Relationship with Answers
    public function answers()
    {
        return $this->hasMany(ExamAnswer::class);
    }
}