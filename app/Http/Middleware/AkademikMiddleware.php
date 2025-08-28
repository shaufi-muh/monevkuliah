<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AkademikMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login DAN perannya adalah 'akademik'
        if (Auth::check() && Auth::user()->role == 'akademik') {
            return $next($request);
        }

        // Jika tidak, tendang ke halaman login dengan pesan error
        return redirect('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
