<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticateWithCookie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

         $token = $request->cookie('auth_token');

        if (!$token) {
            return response()->json(['message' => 'Não autenticado'], 401);
        }

        $accessToken = PersonalAccessToken::findToken($token);

        if (!$accessToken) {
            return response()->json(['message' => 'Token inválido ou expirado'], 401);
        }

        $user = $accessToken->tokenable;

        Auth::login($user);

        $request->setUserResolver(fn() => $user);

        return $next($request);
    }
}
