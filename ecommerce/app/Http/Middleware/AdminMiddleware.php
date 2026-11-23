<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user udah login DAN role-nya 'admin'
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // Kalau pembeli biasa nekad masuk, tendang pake error 403
        abort(403, 'Eits! Cuma Admin yang boleh ngakses halaman Gudang Barang!');
    }
    
}

