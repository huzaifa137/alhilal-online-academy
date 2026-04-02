<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fullname',          // NEW: Full name field
        'username',
        'email',
        'password',
        'phonenumber',       // Phone number (required)
        'temp_otp',
        'registration_status', // NEW: 0 = pending, 1 = verified
        'user_role',
        'user_status',
        'procurement_approval_status',
        'firstname',
        'lastname',
        'gender',
        'user_id',
        'account_status',
        'supervisor',
        'title',
        'user_supervisor',
        'user_title',
        'procurement_year',
        'user_reference',
        'user_last_active',
        'user_signature',
        'passport_number',
        'country',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'registration_status' => 'integer',
        'user_role' => 'integer',
        'account_status' => 'integer',
    ];

    // Accessor to get full name
    public function getFullNameAttribute()
    {
        if ($this->fullname) {
            return $this->fullname;
        }
        return $this->firstname . ' ' . $this->lastname;
    }

    public function completedLessons()
    {
        return $this->belongsToMany(Lesson::class)->withTimestamps();
    }

    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class)
            ->withPivot('score', 'total', 'attempt_number', 'completed_at')
            ->withTimestamps();
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'lesson_user')->withTimestamps();
    }
}