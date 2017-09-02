<?php

namespace App\Http\Middleware;

class Permission
{
    public function handle($request, $next, $permission)
    {
        if (!auth()->user()->can($permission)) {
            return redirect()->route('index');
        }

        return $next($request);
    }
}