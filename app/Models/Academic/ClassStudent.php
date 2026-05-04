<?php

namespace App\Models\Academic;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ClassStudent extends Model
{
    protected $table = 'class_students';
    
    protected $fillable = [
        'class_id',
        'student_id',
        'enrollment_date',
        'status'
    ];
    
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
    
    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
}