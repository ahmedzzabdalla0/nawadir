<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Arr;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request,$guards=['system_admin'])
    {
        if (! $request->expectsJson()) {
            $guard = Arr::get($guards, 0);
            switch ($guard) {
                case 'system_admin':
                    $login = 'system_admin.login';
                    break;
                case 'web':
                    $login = 'website.login';
                    break;

                default:
                    $login = 'website.login';
                    break;
            }
            return route($login);
        }


    }
}
