<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    protected $fillable = [
        'name', 'code', 'description', 'sort_order', 'status'
    ];
    
    protected $casts = [
        'status' => 'string',
    ];
    
    // Relationships
    public function levels(): HasMany
    {
        return $this->hasMany(Level::class)->orderBy('sort_order');
    }
    
    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class);
    }
    
    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
    
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}