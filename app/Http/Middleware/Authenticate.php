<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Exceptions\HttpResponseException;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    // protected function redirectTo($request)
    // {
    //     if (! $request->expectsJson()) {
    //         return route('login');
    //     }
     
    // }
    protected function unauthenticated($request, array $guards)
    {
        // Trả về lỗi JSON thay vì redirect
        throw new HttpResponseException(
            response()->json([
                'message' => 'Unauthorized',
            ], 401)
        );
    }
}
