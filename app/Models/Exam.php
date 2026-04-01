<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'level',
        'subject',
        'duration',
        'total_questions',
        'passing_score',
        'is_active',
        'teacher_id',
        'description'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'duration' => 'integer'
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function attempts()
    {
        return $this->hasMany(ExamAttempt::class);
    }
}