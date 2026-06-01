<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BendaharaMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->isBendahara()) {
            abort(403, 'Akses ditolak. Hanya bendahara yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}
