<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // return $next($request);
        if (auth()->user()->jabatan == 'DIREKTUR' || auth()->user()->jabatan == 'FINANCE' || auth()->user()->jabatan == 'STAFF') {
            return $next($request);
        }
        return abort(403, 'Anda tidak memiliki akses');
    }
}
