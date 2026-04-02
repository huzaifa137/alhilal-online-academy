<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail; 

class EmailController extends Controller
{
    public function welcomeEmail(){
        Mail::to('recepient@gmail.com')->send(new welcomeEmail());

        return 'email sent successfully';
    }
}
