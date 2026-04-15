<?php

namespace App\Models\Assessment;

use App\Models\Academic\ClassModel;
use App\Models\Academic\Lesson;
use App\Models\Academic\Subject;
use App\Models\Academic\Topic;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exam extends Model
{
    protected $fillable = [
        'class_id', 'subject_id', 'lesson_id', 'topic_id', 'teacher_id',
        'title', 'exam_type', 'total_marks', 'pass_mark', 'duration_minutes',
        'available_from', 'available_to', 'instructions', 'allow_late_submission',
        'shuffle_questions', 'status'
    ];
    
    protected $casts = [
        'exam_type' => 'string',
        'status' => 'string',
        'available_from' => 'datetime',
        'available_to' => 'datetime',
        'allow_late_submission' => 'boolean',
        'shuffle_questions' => 'boolean',
    ];
    
    // Relationships
    public function class(): BelongsTo
    {
        return $this->belongsTo(ClassModel::class);
    }
    
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
    
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
    
    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }
    
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class)->orderBy('sort_order');
    }
    
    public function attempts(): HasMany
    {
        return $this->hasMany(ExamAttempt::class);
    }
    
    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
    
    public function scopeByClass($query, $classId)
    {
        return $query->where('class_id', $classId);
    }
    
    public function scopeBySubject($query, $subjectId)
    {
        return $query->where('subject_id', $subjectId);
    }
    
    public function scopeAvailable($query)
    {
        return $query->where('status', 'published')
                     ->where('available_from', '<=', now())
                     ->where(function($q) {
                         $q->whereNull('available_to')
                           ->orWhere('available_to', '>=', now());
                     });
    }
    
    public function scopeByType($query, $type)
    {
        return $query->where('exam_type', $type);
    }
    
    // Helper methods
    public function isAvailable(): bool
    {
        if ($this->status !== 'published') return false;
        if ($this->available_from && now()->lt($this->available_from)) return false;
        if ($this->available_to && now()->gt($this->available_to)) return false;
        return true;
    }
    
    public function hasStudentAttempted($studentId): bool
    {
        return $this->attempts()->where('student_id', $studentId)->exists();
    }
    
    public function getStudentAttempt($studentId): ?ExamAttempt
    {
        return $this->attempts()->where('student_id', $studentId)->first();
    }
    
    public function getTotalQuestionsCount(): int
    {
        return $this->questions()->count();
    }
    
    public function getStudentResult($studentId): ?ExamAttempt
    {
        return $this->attempts()
                    ->where('student_id', $studentId)
                    ->whereIn('status', ['submitted', 'graded'])
                    ->first();
    }
    
    public function getClassAverage(): ?float
    {
        return $this->attempts()
                    ->whereIn('status', ['submitted', 'graded'])
                    ->whereNotNull('percentage')
                    ->avg('percentage');
    }
    
    public function publish(): void
    {
        $this->update(['status' => 'published']);
    }
    
    public function close(): void
    {
        $this->update(['status' => 'closed']);
    }
}