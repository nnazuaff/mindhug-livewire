<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->status !== 'active') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login')->withErrors([
                'identifier' => 'Akun ini telah dihapus / dinonaktifkan. Hubungi tim MindHug untuk info lebih lanjut.',
            ]);
        }

        return $next($request);
    }
}
