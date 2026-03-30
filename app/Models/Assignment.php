<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // ✅ Correct import
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'instructions',
        'type',
        'type_id',
        'due_date',
        'file_upload_required',
    ];

    public function submissions()
    {
        return $this->hasMany(UserAssignmentSubmission::class);
    }

    public function parent()
    {
        return $this->morphTo(__FUNCTION__, 'type', 'type_id');
    }
}
