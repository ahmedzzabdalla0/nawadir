<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;

class LogoutAdminSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        if(session('is_logged') && session('login_time')){
            $time = session('login_time');
            $is_time = Carbon::parse($time)->addMinutes(360)->lessThanOrEqualTo(Carbon::now());
            if(!$request->expectsJson() && $is_time){
                return redirect()->route('system_admin.logout');
            }
        }
        return $next($request);
    }

}
