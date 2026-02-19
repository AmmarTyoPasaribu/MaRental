<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\SupabaseAuthService;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!SupabaseAuthService::check()) {
            return redirect()->route('login')->with([
                'message' => 'Silakan login terlebih dahulu.',
                'alert-type' => 'danger'
            ]);
        }

        if (!SupabaseAuthService::isAdmin()) {
            return redirect()->route('homepage')->with([
                'message' => 'Anda tidak memiliki akses admin.',
                'alert-type' => 'danger'
            ]);
        }

        return $next($request);
    }
}