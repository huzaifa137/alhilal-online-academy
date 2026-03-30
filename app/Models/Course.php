<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id',
        'title',
        'description',
        'language',
        'difficulty',
        'tags',
        'thumbnail',
        'selling_price',
        'old_price',
        'category_id',
        'is_published',
        'pricing_category',
    ];

    // If using JSON for tags, ensure it's casted properly
    protected $casts = [
        'tags' => 'array',
    ];

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function quizzes()
    {
        return $this->morphMany(Quiz::class, 'parent', 'type', 'type_id');
    }

    public function assignments()
    {
        return $this->morphMany(Assignment::class, 'parent', 'type', 'type_id');
    }

    public function lessons()
    {
        return $this->hasManyThrough(Lesson::class, Module::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'user_id');
    }
}
