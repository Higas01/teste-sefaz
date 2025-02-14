<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CorsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        header("Access-Control-Allow-Origin: *");

        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS");

        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

        if ($request->getMethod() == "OPTIONS") {
            return response()->json('{"status": "ok"}');
        }

        return $next($request);
    }
}
