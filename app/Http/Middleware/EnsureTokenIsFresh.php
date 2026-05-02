<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenIsFresh
{
    private const TIMEOUT_MINUTES = 120;

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $token = $user?->currentAccessToken();

        if (!$token) {
            return response()->json([
                'errors' => [
                    'message' => 'Unauthorized.',
                ],
            ], 401);
        }

        $lastUsed = $token->last_used_at ?? $token->created_at;

        if ($lastUsed && now()->diffInMinutes($lastUsed) >= self::TIMEOUT_MINUTES) {
            $token->delete();

            return response()->json([
                'errors' => [
                    'message' => 'Session expired.',
                ],
            ], 401);
        }

        $token->forceFill(['last_used_at' => now()])->save();

        return $next($request);
    }
}
