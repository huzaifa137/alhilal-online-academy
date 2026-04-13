<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->path();

        // Routes that don't require login
        $publicRoutes = [
            'users/login',
            'users/register',
            'users/home-page',
            'users/user-otp',
            'users/forgot-password',
        ];

        $publicRouteNames = [
            'auth-user-check',
            'users.terms-and-conditions',
            'password/reset',
        ];

        // If admin not logged in and trying to access protected routes
        if (!session()->has('LoggedAdmin') && !in_array($path, $publicRoutes) && !$request->routeIs(...$publicRouteNames)) {
            Session::put('url.intended', $request->url());
            return redirect('/users/home-page')->with('fail', 'You must be logged in');
        }

        // Redirect logged students away from login/register/home-page
        if (session()->has('LoggedStudent') && in_array($path, ['users/login', 'users/register', 'users/home-page'])) {
            return redirect('/student/dashboard');
        }

        // Redirect logged admins away from login/register/home-page
        if (session()->has('LoggedAdmin') && in_array($path, ['users/login', 'users/register', 'users/home-page'])) {
            return redirect('/');
        }

        // Redirect logged teachers away from login/register/home-page
        if (session()->has('LoggedTeacher') && in_array($path, ['users/login', 'users/register', 'users/home-page'])) {
            return redirect('/teacher/dashboard');
        }

        $response = $next($request);

        $response->headers->set('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Sat, 01 Jan 1990 00:00:00 GMT');

        return $response;
    }
}
