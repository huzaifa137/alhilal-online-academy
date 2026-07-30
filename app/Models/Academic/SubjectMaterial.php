<?php

namespace App\Models\Academic;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubjectMaterial extends Model
{
    protected $fillable = [
        'class_id', 'subject_id', 'teacher_id',
        'title', 'description', 'type', 'file_path',
        'file_size', 'amount', 'sort_order', 'status',
    ];

    protected $casts = [
        'status' => 'string',
        'type' => 'string',
    ];

    // ── Relationships ───────────────────────────────────────────────
    public function class(): BelongsTo
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function materialPayments(): HasMany
    {
        return $this->hasMany(MaterialPayment::class, 'subject_material_id');
    }

    // ── Scopes ──────────────────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeForClass($query, $classId)
    {
        return $query->where('class_id', $classId);
    }

    public function scopeForSubject($query, $subjectId)
    {
        return $query->where('subject_id', $subjectId);
    }

    // ── Payment gating (mirrors Lesson::isFree() / isPaidByStudent()) ──
    public function isFree(): bool
    {
        $amount = (float) str_replace(',', '', (string) $this->amount);
        return $amount <= 0;
    }

    public function isPaidByStudent(?int $studentId): bool
    {
        if ($this->isFree()) {
            return true;
        }

        if (!$studentId) {
            return false;
        }

        if ($this->relationLoaded('materialPayments')) {
            return $this->materialPayments->contains('student_id', $studentId);
        }

        return $this->materialPayments()->where('student_id', $studentId)->exists();
    }

    // ── Accessors ───────────────────────────────────────────────────
    public function getIconClassAttribute(): string
    {
        return match ($this->type) {
            'pdf' => 'fa-file-pdf',
            'document' => 'fa-file-alt',
            'image' => 'fa-image',
            default => 'fa-file',
        };
    }

    public function getFileSizeFormattedAttribute(): string
    {
        if (!$this->file_size) {
            return '';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->file_size;
        $unit = 0;

        while ($size >= 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }

        return round($size, 1) . ' ' . $units[$unit];
    }
}