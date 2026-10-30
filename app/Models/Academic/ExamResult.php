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

    /** Only results of quizzes taught in $language (null = no filter). */
    public function scopeInLanguage($query, ?string $language)
    {
        if ($language === null || $language === '') {
            return $query;
        }

        return $query->whereHas('exam', fn ($q) => $q->where('exams.language', $language));
    }

    /** Results that belong to the language the visitor currently has selected. */
    public function scopeForViewerLanguage($query)
    {
        return $query->inLanguage(\App\Support\ContentLanguage::viewerLanguage());
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