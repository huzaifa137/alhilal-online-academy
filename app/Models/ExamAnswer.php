<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'attempt_id',
        'question_id',
        'answer',
        'is_correct'
    ];

    protected $casts = [
        'is_correct' => 'boolean'
    ];

    // Relationship with Attempt
    public function attempt()
    {
        return $this->belongsTo(ExamAttempt::class);
    }

    // Relationship with Question
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}