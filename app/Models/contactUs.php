<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class contactUs extends Model
{
    protected $fillable = [
        'student_email',
        'student_subject',
        'student_message',
        'student_id',
        'admin_response_status',
        'admin_response_message',
        'admin_responded_by',
        'date_added',
    ];
}
