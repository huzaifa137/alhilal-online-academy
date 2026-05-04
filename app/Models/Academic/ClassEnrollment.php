<?php
// app/Models/Academic/ClassEnrollment.php

namespace App\Models\Academic;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ClassEnrollment extends Model
{
    protected $table = 'class_enrollments';
    
    protected $fillable = [
        'class_id',
        'student_id',
        'enrollment_date',
        'status',
        'payment_status',
        'amount_paid'
    ];
    
    protected $casts = [
        'enrollment_date' => 'datetime',
    ];
    
    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
    
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}