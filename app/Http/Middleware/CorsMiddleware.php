<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CorsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $allowedOrigins = [
            'https://staff-management-react.vercel.app',
            'http://localhost:5173',
        ];
        
        $origin = $request->header('Origin');
        
        // Check if origin is allowed (hardcoded list)
        $isAllowed = in_array($origin, $allowedOrigins);
        
        // Or if origin is from Vercel domain (dynamic subdomain)
        if (!$isAllowed && $origin && str_contains($origin, 'vercel.app')) {
            $isAllowed = true;
        }
        
        // Handle preflight requests
        if ($request->getMethod() === 'OPTIONS') {
            $response = response('', 200);
            
            if ($isAllowed) {
                $response->headers->set('Access-Control-Allow-Origin', $origin);
            }
            
            $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS, PATCH');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
            $response->headers->set('Access-Control-Allow-Credentials', 'true');
            $response->headers->set('Access-Control-Max-Age', '86400');
            
            return $response;
        }
        
        $response = $next($request);
        
        if ($isAllowed) {
            $response->headers->set('Access-Control-Allow-Origin', $origin);
        }
        
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS, PATCH');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');
        
        return $response;
    }
}
