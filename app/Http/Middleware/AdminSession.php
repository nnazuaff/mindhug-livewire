<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminSession
{
    public function handle(Request $request, Closure $next)
    {
        config(['session.cookie' => 'mindhug_admin_session']);
        return $next($request);
    }
}
