<?php

namespace App\Models\Academic;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamAttempt extends Model
{
    protected $fillable = [
        'exam_id', 'student_id', 'started_at', 'submitted_at', 'time_spent_seconds',
        'marks_obtained', 'percentage', 'is_passed', 'status', 'teacher_feedback',
        'graded_by', 'graded_at'
    ];
    
    protected $casts = [
        'started_at' => 'datetime',
        'submitted_at' => 'datetime',
        'graded_at' => 'datetime',
        'marks_obtained' => 'decimal:2',
        'percentage' => 'decimal:2',
        'is_passed' => 'boolean',
        'status' => 'string',
    ];
    
    // Relationships
    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }
    
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }
    
    public function gradedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'graded_by');
    }
    
    public function answers(): HasMany
    {
        return $this->hasMany(ExamAnswer::class);
    }
    
    // Scopes
    public function scopeSubmitted($query)
    {
        return $query->whereIn('status', ['submitted', 'graded']);
    }
    
    public function scopeGraded($query)
    {
        return $query->where('status', 'graded');
    }
    
    public function scopePassed($query)
    {
        return $query->where('is_passed', true);
    }
    
    // Helper methods
    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }
    
    public function isSubmitted(): bool
    {
        return in_array($this->status, ['submitted', 'graded']);
    }
    
    public function isGraded(): bool
    {
        return $this->status === 'graded';
    }
    
    public function submit(): void
    {
        $this->update([
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);
    }
    
    public function calculateScore(): void
    {
        $totalMarks = $this->exam->total_marks;
        $obtainedMarks = $this->answers()->sum('marks_obtained');
        $percentage = $totalMarks > 0 ? ($obtainedMarks / $totalMarks) * 100 : 0;
        $isPassed = $percentage >= $this->exam->pass_mark;
        
        $this->update([
            'marks_obtained' => $obtainedMarks,
            'percentage' => $percentage,
            'is_passed' => $isPassed,
            'status' => 'graded',
            'graded_at' => now(),
        ]);
    }
    
    public function getGradeAttribute(): string
    {
        if (!$this->percentage) return 'N/A';
        
        return match(true) {
            $this->percentage >= 90 => 'A+',
            $this->percentage >= 80 => 'A',
            $this->percentage >= 75 => 'B+',
            $this->percentage >= 70 => 'B',
            $this->percentage >= 65 => 'C+',
            $this->percentage >= 60 => 'C',
            $this->percentage >= 55 => 'D+',
            $this->percentage >= 50 => 'D',
            default => 'F',
        };
    }
}