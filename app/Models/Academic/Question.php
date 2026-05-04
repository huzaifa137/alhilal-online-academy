<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    protected $fillable = [
        'exam_id', 'question_number', 'question', 'question_arabic',
        'type', 'marks', 'options', 'answer', 'hint', 'explanation', 'sort_order'
    ];
    
    protected $casts = [
        'type' => 'string',
        'options' => 'array',
        'marks' => 'integer',
    ];
    
    // Relationships
    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }
    
    public function answers(): HasMany
    {
        return $this->hasMany(ExamAnswer::class);
    }
    
    // Accessors
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'mcq' => 'Multiple Choice',
            'true_false' => 'True/False',
            'short_answer' => 'Short Answer',
            'essay' => 'Essay',
            'oral' => 'Oral',
            'upload' => 'File Upload',
            default => 'Question',
        };
    }
    
    public function getOptionsArrayAttribute(): array
    {
        return $this->options ?? [];
    }
    
    // Helper methods
    public function isAutoGradable(): bool
    {
        return in_array($this->type, ['mcq', 'true_false']);
    }
    
    public function requiresManualGrading(): bool
    {
        return in_array($this->type, ['short_answer', 'essay', 'oral', 'upload']);
    }
    
    public function checkAnswer($studentAnswer): bool
    {
        if (!$this->isAutoGradable()) {
            return false;
        }
        
        if ($this->type === 'true_false') {
            return strtolower(trim($studentAnswer)) === strtolower(trim($this->answer));
        }
        
        if ($this->type === 'mcq') {
            return strtoupper(trim($studentAnswer)) === strtoupper(trim($this->answer));
        }
        
        return false;
    }
}