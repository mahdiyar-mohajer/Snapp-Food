<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRestaurantProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && !$user->resturant) {
            // Ensure that the current route is not 'resturant.profile' before redirecting
            if (!$request->is('resturant.profile')) {
                return redirect()->route('resturant.profile');
            }
        }
        return $next($request);
    }
}
