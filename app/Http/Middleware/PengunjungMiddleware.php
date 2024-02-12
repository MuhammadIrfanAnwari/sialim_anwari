<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\pengunjung;

class PengunjungMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();
        if (pengunjung::where('tanggal', today())->where('ip', $ip)->count() < 1)
        {
            pengunjung::create([
                'tanggal' => today(),
                'ip' => $ip,
            ]);
        }
        return $next($request);
    }
}
