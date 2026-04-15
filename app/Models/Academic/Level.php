<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    protected $fillable = [
        'section_id', 'name', 'code', 'description', 'sort_order', 'status'
    ];
    
    protected $casts = [
        'status' => 'string',
    ];
    
    // Relationships
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
    
    public function classes(): HasMany
    {
        return $this->hasMany(ClassModel::class)->orderBy('name');
    }
    
    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
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