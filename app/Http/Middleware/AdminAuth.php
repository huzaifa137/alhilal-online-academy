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

        $isLoggedIn = session()->has('LoggedAdmin') || session()->has('LoggedStudent') || session()->has('LoggedTeacher');


        // Protect private routes
        if (!$isLoggedIn && !in_array($path, $publicRoutes) && !$request->routeIs(...$publicRouteNames)) {

            Session::put('url.intended', $request->url());
            return redirect('/users/home-page')->with('fail', 'You must be logged in');
        }

        // Redirect logged-in users away from guest pages
        $guestOnlyRoutes = [
            'users/login',
            'users/register',
            'users/home-page',
            '/',
        ];

        if (in_array($path, $guestOnlyRoutes)) {
            $redirects = [
                'LoggedStudent' => '/student/dashboard',
                'LoggedAdmin' => '/users/dashboard',
                'LoggedTeacher' => '/teacher/dashboard',
            ];

            foreach ($redirects as $sessionKey => $redirectPath) {
                if (session()->has($sessionKey)) {
                    return redirect($redirectPath);
                }
            }
        }

        $response = $next($request);

        $response->headers->set(
            'Cache-Control',
            'no-cache, no-store, max-age=0, must-revalidate'
        );
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Sat, 01 Jan 1990 00:00:00 GMT');

        return $response;
    }
}
