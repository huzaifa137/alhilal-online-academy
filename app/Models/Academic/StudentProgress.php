<?php

namespace App\Models\Progress;

use App\Models\Academic\Lesson;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentProgress extends Model
{
    protected $fillable = [
        'student_id', 'lesson_id', 'status', 'score', 'time_spent_seconds',
        'last_position_seconds', 'started_at', 'completed_at'
    ];
    
    protected $casts = [
        'status' => 'string',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];
    
    // Relationships
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }
    
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
    
    // Scopes
    public function scopeCompleted($query)
    {
        return $query->whereIn('status', ['completed', 'passed']);
    }
    
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }
    
    public function scopeNotStarted($query)
    {
        return $query->where('status', 'not_started');
    }
    
    public function scopeByStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }
    
    // Helper methods
    public function markAsStarted(): void
    {
        if ($this->status === 'not_started') {
            $this->update([
                'status' => 'in_progress',
                'started_at' => now(),
            ]);
        }
    }
    
    public function markAsCompleted($score = null): void
    {
        $this->update([
            'status' => $score && $score >= 50 ? 'passed' : 'completed',
            'score' => $score,
            'completed_at' => now(),
        ]);
    }
    
    public function updatePosition($seconds): void
    {
        $this->update(['last_position_seconds' => $seconds]);
    }
    
    public function addTimeSpent($seconds): void
    {
        $this->increment('time_spent_seconds', $seconds);
    }
    
    public function isCompleted(): bool
    {
        return in_array($this->status, ['completed', 'passed']);
    }
    
    public function isPassed(): bool
    {
        return $this->status === 'passed';
    }
}