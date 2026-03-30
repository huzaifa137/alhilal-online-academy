<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function usersCompleted()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function quizzes()
    {
        return $this->morphMany(Quiz::class, 'parent', 'type', 'type_id');
    }

    public function assignments()
    {
        return $this->morphMany(Assignment::class, 'parent', 'type', 'type_id');
    }

    public function quiz()
    {
        return $this->morphOne(Quiz::class, 'parent', 'type', 'type_id');
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class)->withTimestamps();
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

}
