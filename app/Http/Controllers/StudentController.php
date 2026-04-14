<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class StudentController extends Controller
{

    public function register(Request $request)
    {
        return view('users.register');
    }

    public function homePage()
    {
        return view('home-page');
    }

    public function studentDashboard()
    {
        return view('Student.dashboard');
    }

    public function user_terms_and_conditions(Request $request)
    {
        return view('users.terms-and-conditions');
    }

    public function login(Request $request)
    {
        return view('users.login');
    }

    public function studentProfile()
    {
        $loggedInUser = Helper::getLoggedInUser();

        if (!$loggedInUser) {
            return redirect('/users/home-page')
                ->with('fail', 'You must be logged in');
        }

        $user = DB::table('users')
            ->where('id', $loggedInUser['id'])
            ->first();

        return view('users.user-profile', compact('user'));
    }
}
