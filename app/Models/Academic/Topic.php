<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model
{
    protected $fillable = [
        'subject_id', 'class_id', 'title', 'title_arabic',
        'description', 'learning_objectives', 'order_no', 'status'
    ];
    
    protected $casts = [
        'status' => 'string',
    ];
    
    // Relationships
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
    
    public function class(): BelongsTo
    {
        return $this->belongsTo(ClassModel::class);
    }
    
    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class)->orderBy('lesson_order');
    }
    
    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }
    
    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
    
    public function scopeOrdered($query)
    {
        return $query->orderBy('order_no');
    }
    
    // Helper methods
    public function getProgressForStudent($studentId): array
    {
        $totalLessons = $this->lessons()->count();
        if ($totalLessons === 0) {
            return ['completed' => 0, 'total' => 0, 'percentage' => 0];
        }
        
        $completedLessons = StudentProgress::where('student_id', $studentId)
            ->whereIn('lesson_id', $this->lessons()->pluck('id'))
            ->where('status', 'completed')
            ->count();
            
        return [
            'completed' => $completedLessons,
            'total' => $totalLessons,
            'percentage' => round(($completedLessons / $totalLessons) * 100, 1)
        ];
    }
}