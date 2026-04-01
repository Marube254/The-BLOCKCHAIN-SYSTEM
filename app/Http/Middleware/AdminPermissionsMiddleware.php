<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminPermissionsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        if ($user && !$user->isSuperAdmin()) {
            // Hide delete buttons for regular admins
            \Filament\Facades\Filament::registerRenderHook(
                'tables::actions',
                fn () => '<style>.delete-action { display: none; }</style>'
            );
        }
        
        return $next($request);
    }
}
