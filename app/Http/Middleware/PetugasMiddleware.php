<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PetugasMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->isPetugas()) {
            return $next($request);
        }
        
        return redirect('/login')->with('error', 'Akses ditolak');
    }
} 