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
        
        $response = $next($request);
        
        if (in_array($origin, $allowedOrigins)) {
            $response->headers->set('Access-Control-Allow-Origin', $origin);
        }
        
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS, PATCH');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');
        
        if ($request->getMethod() === 'OPTIONS') {
            return response('', 200, $response->headers->all());
        }
        
        return $response;
    }
}
