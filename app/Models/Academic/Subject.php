<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    protected $fillable = [
        'section_id', 'name', 'name_arabic', 'code', 'category',
        'description', 'icon', 'color', 'sort_order', 'status'
    ];
    
    protected $casts = [
        'status' => 'string',
        'category' => 'string',
    ];
    
    // Relationships
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
    
    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(ClassModel::class, 'class_subjects')
                    ->withPivot(['teacher_id', 'periods_per_week', 'is_compulsory', 'passing_marks', 'full_marks'])
                    ->withTimestamps();
    }
    
    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }
    
    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
    
    public function scopeIslamic($query)
    {
        return $query->where('category', 'islamic');
    }
    
    public function scopeBySection($query, $sectionId)
    {
        return $query->where('section_id', $sectionId);
    }
    
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}