<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{

    public function register(Request $request)
    {
        return view('users.register');
    }

    public function studentDashboard(){
        return view('student.dashboard');
    }

    public function user_terms_and_conditions(Request $request)
    {
        return view('users.terms-and-conditions');
    }
}
