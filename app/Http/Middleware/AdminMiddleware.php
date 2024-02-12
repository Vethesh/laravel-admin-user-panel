<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
     {
    //     if (Auth()->check() && auth()->user()->user_type === 'admin') {
    //         return $next($request);
    //     }

    //     return redirect(route('home'))->with('error', 'You do not have permission to access this page.');

    if (Auth::user()->user_type !='admin'){
            session()->flush();
            return redirect()->route('login');
    }
    }
}
