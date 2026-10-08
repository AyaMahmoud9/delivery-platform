<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->guard('web')->check()) {
            return redirect()->route('admin.login');
        }

        if (auth()->guard('web')->user()->type !== 'admin') {
            abort(403);
        }

        return $next($request);
    }
}