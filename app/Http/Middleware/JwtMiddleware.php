<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponseTrait;
use Closure;
use Exception;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use Symfony\Component\HttpFoundation\Response;

class JwtMiddleware
{
    use ApiResponseTrait;
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // 1. Parse and authenticate the token to get the user
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return $this->errorResponse('User not found', 404);
            }

            $companyId = null;

            if ($user->role === 'company') {
                $companyId = $user->Comapny ? $user->Comapny->id : null;
            } elseif ($user->role === 'staff') {
                $companyId = $user->company_id;
            }

            $request->merge([
                'user_id'    => $user->id,
                'user_role'  => $user->role,
                'company_id' => $companyId,
            ]);
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException) {
                return $this->errorResponse('Token is invalid', 401);
            } else if ($e instanceof TokenExpiredException) {
                return $this->errorResponse('Token has expired', 401);
            } else {

                return $this->errorResponse('Authorization token not found', 401);
            }
        }

        return $next($request);
    }
}
