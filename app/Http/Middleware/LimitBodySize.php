<?php

namespace App\Http\Middleware;

use Closure;

class LimitBodySize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $maxContentLength = 1024 * 1024;
        if ($request->header('Content-Length') > $maxContentLength) {
            return response()->json(['error' => 'Payload too large'], 413);
        }
        return $next($request);
    }
}
