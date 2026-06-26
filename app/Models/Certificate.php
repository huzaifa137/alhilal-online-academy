<?php

namespace App\Models;

use App\Models\Academic\ClassModel;
use App\Models\Academic\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    protected $table = 'certificates';

    protected $fillable = [
        'student_id',
        'class_id',
        'section_id',
        'certificate_no',
        'verification_code',
        'type',
        'title',
        'description',
        'issued_date',
        'grade',
        'percentage',
        'pdf_path',
        'template_used',
        'status',
        'issued_at',
        'revoked_reason',
    ];

    protected $casts = [
        'issued_date' => 'date',
        'issued_at'   => 'datetime',
        'percentage'  => 'decimal:2',
    ];

    // ── Relationships ──────────────────────────────────────────────────────────

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    // ── Scopes ─────────────────────────────────────────────────────────────────

    public function scopeIssued($query)
    {
        return $query->where('status', 'issued');
    }

    public function scopeRevoked($query)
    {
        return $query->where('status', 'revoked');
    }

    public function scopeByStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    // ── Helpers ────────────────────────────────────────────────────────────────

    public function isRevoked(): bool
    {
        return $this->status === 'revoked';
    }

    public function isIssued(): bool
    {
        return $this->status === 'issued';
    }

    /**
     * Generate a unique, human-friendly certificate number.
     * Format: AHA-CERT-{YEAR}-{6 random alphanumeric}
     */
    public static function generateCertificateNo(): string
    {
        do {
            $candidate = 'AHA-CERT-' . now()->format('Y') . '-' . strtoupper(\Illuminate\Support\Str::random(6));
        } while (self::where('certificate_no', $candidate)->exists());

        return $candidate;
    }

    /**
     * Generate a short public verification code, safe to print under a QR code.
     * Format: 4 blocks of 4 uppercase alphanumeric chars, e.g. AH3K-7F2D-9P1X-KM2R
     */
    public static function generateVerificationCode(): string
    {
        do {
            $raw       = strtoupper(\Illuminate\Support\Str::random(16));
            $raw       = str_replace(['0', 'O', '1', 'I'], ['A', 'B', 'C', 'D'], $raw);
            $candidate = implode('-', str_split(substr($raw, 0, 16), 4));
        } while (self::where('verification_code', $candidate)->exists());

        return $candidate;
    }
}