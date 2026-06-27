<?php

namespace App\Models\Academic;

use App\Models\User;
use App\Models\Academic\StudentProgress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
protected $fillable = [
    'topic_id', 'teacher_id', 'title', 'title_arabic', 'description',
    'notes', 'lesson_type', 'video_url', 'audio_url', 'pdf_file',
    'duration', 'lesson_order', 'status', 'published_at',
    'lesson_amount', 'lesson_payment_status'
];
    
protected $casts = [
    'status' => 'string',
    'lesson_type' => 'string',
    'lesson_payment_status' => 'string',
    'published_at' => 'datetime',
];
    
    // Relationships
    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }
    
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    
    public function resources(): HasMany
    {
        return $this->hasMany(LessonResource::class)->orderBy('sort_order');
    }
    
    public function progress(): HasMany
    {
        return $this->hasMany(StudentProgress::class);
    }
    
    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }

    public function lessonPayments(): HasMany
    {
        return $this->hasMany(LessonPayment::class);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }
    
    public function scopeByTopic($query, $topicId)
    {
        return $query->where('topic_id', $topicId);
    }
    
    public function scopeOrdered($query)
    {
        return $query->orderBy('lesson_order');
    }
    
    // Helper methods
    public function markAsPublished(): void
    {
        $this->update([
            'status' => 'published',
            'published_at' => now(),
        ]);
    }
    
    public function getProgressForStudent($studentId): ?StudentProgress
    {
        return $this->progress()->where('student_id', $studentId)->first();
    }
    
    public function hasStudentCompleted($studentId): bool
    {
        return $this->progress()
                    ->where('student_id', $studentId)
                    ->whereIn('status', ['completed', 'passed'])
                    ->exists();
    }
    
    public function getNextLesson(): ?self
    {
        return self::where('topic_id', $this->topic_id)
                   ->where('lesson_order', '>', $this->lesson_order)
                   ->orderBy('lesson_order')
                   ->first();
    }
    
    public function getPreviousLesson(): ?self
    {
        return self::where('topic_id', $this->topic_id)
                   ->where('lesson_order', '<', $this->lesson_order)
                   ->orderBy('lesson_order', 'desc')
                   ->first();
    }

    /**
     * A lesson with no price (or a price of 0) is free for everyone.
     */
    public function isFree(): bool
    {
        $amount = (float) str_replace(',', '', (string) $this->lesson_amount);
        return $amount <= 0;
    }

    /**
     * Whether THIS specific student has paid for THIS lesson.
     * Free lessons are always accessible. Paid lessons require a
     * matching row in lesson_payments for this exact student.
     */
    public function isPaidByStudent(?int $studentId): bool
    {
        if ($this->isFree()) {
            return true;
        }

        if (!$studentId) {
            return false;
        }

        // Use already-loaded relation when available to avoid N+1 queries.
        if ($this->relationLoaded('lessonPayments')) {
            return $this->lessonPayments->contains('student_id', $studentId);
        }

        return $this->lessonPayments()->where('student_id', $studentId)->exists();
    }
}