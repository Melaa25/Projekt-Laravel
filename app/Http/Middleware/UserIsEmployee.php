<?php

// app/Http/Middleware/UserIsEmployee.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserIsEmployee
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'employee') {
            return $next($request);
        }

        return redirect()->route('home')->with('error', 'You are not authorized to access this page.');
    }
}
