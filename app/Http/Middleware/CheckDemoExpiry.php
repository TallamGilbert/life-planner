<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckDemoExpiry
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->is_demo && Auth::user()->isDemoExpired()) {
            Auth::logout();
            
            return redirect()->route('register')
                ->with('warning', 'Your demo session has expired. Sign up to continue using Life Planner!');
        }

        return $next($request);
    }
}