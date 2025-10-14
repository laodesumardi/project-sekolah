<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTeacherRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Check if user has teacher role
        if (auth()->user()->role !== 'teacher') {
            // Redirect based on user role
            return match(auth()->user()->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'student' => redirect()->route('student.dashboard'),
                default => redirect()->route('home')
            };
        }

        return $next($request);
    }
}