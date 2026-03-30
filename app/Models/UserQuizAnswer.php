<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserQuizAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_quiz_attempt_id',
        'question_id',
        'answer',
        'is_correct',
    ];

    public function attempt()
    {
        return $this->belongsTo(UserQuizAttempt::class, 'user_quiz_attempt_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
