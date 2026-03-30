<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'type', 'type_id'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function attempts()
    {
        return $this->hasMany(UserQuizAttempt::class);
    }

    public function parent()
    {
        return $this->morphTo('parent', 'type', 'type_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('score', 'total', 'attempt_number', 'completed_at')
            ->withTimestamps();
    }

}
