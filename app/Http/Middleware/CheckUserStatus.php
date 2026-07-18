<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('web')->check() && Auth::guard('web')->user()->status !== 'active') {
            Auth::guard('web')->logout();

            return redirect('/login')->withErrors([
                'identifier' => 'Akun ini telah dinonaktifkan. Hubungi tim MindHug.',
            ]);
        }

        return $next($request);
    }
}
