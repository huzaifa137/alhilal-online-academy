<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function quizzes()
    {
        return $this->morphMany(Quiz::class, 'parent', 'type', 'type_id');
    }

    public function assignments()
    {
        return $this->morphMany(Assignment::class, 'parent', 'type', 'type_id');
    }

}
