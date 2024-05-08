<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response {
        $apiKey = $request->header('X-API-Key');

        if (!$apiKey) {
            return response()->json(['message' => 'API key is missing'], 401);
        }

        $apiKeyModel = ApiKey::where('key', $apiKey)->first();

        if (!$apiKeyModel) {
            return response()->json(['message' => 'Invalid API key'], 401);
        }

        return $next($request);
    }
}
