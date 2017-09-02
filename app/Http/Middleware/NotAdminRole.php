<?php

namespace App\Http\Middleware;

class NotAdminRole
{
    public function handle($request, $next)
    {
        if ($request->id == 1) {
            return redirect()->route('roles');
        }
        else {
            return $next($request);
        }
    }
}