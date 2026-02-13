<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class RateLimitMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $maxAttempts = '60'): Response
    {
        $key = $this->resolveRequestSignature($request);

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            
            return response()->json([
                'success' => false,
                'message' => 'Too many requests. Please try again later.',
                'retry_after' => $seconds,
            ], 429);
        }

        RateLimiter::hit($key);

        $response = $next($request);

        return $response->headers->set('X-RateLimit-Limit', $maxAttempts)
            ->headers->set('X-RateLimit-Remaining', RateLimiter::remaining($key, $maxAttempts));
    }

    /**
     * Resolve the request signature for rate limiting.
     */
    protected function resolveRequestSignature(Request $request): string
    {
        if ($user = $request->user()) {
            return 'user:' . $user->id;
        }

        if ($route = $request->route()) {
            return 'route:' . $route->getName();
        }

        return 'ip:' . $request->ip();
    }
}
