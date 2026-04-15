<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LessonResource extends Model
{
    protected $fillable = [
        'lesson_id', 'type', 'title', 'file_path', 'external_url',
        'file_size', 'sort_order', 'is_required'
    ];
    
    protected $casts = [
        'type' => 'string',
        'is_required' => 'boolean',
    ];
    
    // Relationships
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
    
    // Accessors
    public function getIconClassAttribute(): string
    {
        return match($this->type) {
            'video' => 'fa-video',
            'audio' => 'fa-headphones',
            'pdf' => 'fa-file-pdf',
            'document' => 'fa-file-alt',
            'image' => 'fa-image',
            'external_link' => 'fa-link',
            default => 'fa-file',
        };
    }
    
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'video' => 'Video',
            'audio' => 'Audio',
            'pdf' => 'PDF Document',
            'document' => 'Document',
            'image' => 'Image',
            'external_link' => 'External Link',
            default => 'File',
        };
    }
    
    public function getFileSizeFormattedAttribute(): string
    {
        if (!$this->file_size) return '';
        
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