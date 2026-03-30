<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckFingerprint
{
    public function handle(Request $request, Closure $next)
    {
        $fingerprint = $request->header('X-Fingerprint');
        
        if ($request->user() && config('fingerprint.enabled')) {
            $storedFingerprint = $request->user()->fingerprint_hash;
            
            if ($storedFingerprint && $storedFingerprint !== $fingerprint) {
                return response()->json([
                    'message' => 'Device verification failed. Please login again.'
                ], 401);
            }
            
            if (!$storedFingerprint && $fingerprint) {
                $request->user()->update(['fingerprint_hash' => $fingerprint]);
            }
        }
        
        return $next($request);
    }
}