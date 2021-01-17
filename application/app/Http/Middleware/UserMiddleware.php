<?php

namespace App\Http\Middleware;

use App\Http\Response\ErrorResponse;
use Closure;
use App\Models\User;


class UserMiddleware
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
            return new ErrorResponse('Header x-api-user-id não encontrado');
        }

        $user = User::find($userID);

        if (empty($user)) {
            return new ErrorResponse('Usuário não encontrado');
        }

        $request->user = $user;

        return $next($request);
    }

}
