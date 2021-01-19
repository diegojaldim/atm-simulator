<?php

namespace App\Http\Middleware;

use App\Http\Response\ErrorResponse;
use App\Http\Response\ResponseMessages;
use Closure;
use App\Models\User;


class UserMiddleware implements ResponseMessages
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userID = $request->header('x-api-user-id');

        if (empty($userID)) {
            return new ErrorResponse(self::X_API_USER_ID_NOT_FOUND, 401);
        }

        $user = User::find($userID);

        if (empty($user)) {
            return new ErrorResponse(self::USER_NOT_FOUND, 401);
        }

        $request->user = $user;

        return $next($request);
    }

}
