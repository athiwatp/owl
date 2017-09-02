<?php

namespace App\Http\Middleware;

use Closure;

class Allow
{
    public function handle($request, Closure $next, $key)
    {
        if (!config('owl.allow.'.$key)) {
            return redirect()->route('index');
        }

        return $next($request);
    }
}