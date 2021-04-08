<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Redirector;

class FrontMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!(request()->filled('OpID') || setting('enable_testing'))) {
            abort(404);
        }
        return $next($request);
    }
}
