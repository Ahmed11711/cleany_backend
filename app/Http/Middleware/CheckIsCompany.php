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

class CheckIsCompany
{
    use ApiResponseTrait;

    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return $this->errorResponse('User not found', 404);
            }

            $allowedRoles = ['company', 'staff'];

            if (!in_array($user->role, $allowedRoles)) {
                return $this->errorResponse('Access denied. Unauthorized role.', 403);
            }

            $companyId = null;

            if ($user->role === 'company') {
                $companyId = $user->Comapny ? $user->Comapny->id : null;
            } elseif ($user->role === 'staff') {
                $companyId = $user->company_id;
            }

            $request->merge([
                'auth_user'  => $user,
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
