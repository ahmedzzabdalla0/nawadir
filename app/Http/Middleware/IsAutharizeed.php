<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAutharizeed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$role,$where)
    {

        if (! Auth::guard('system_admin')->user()->hasRole($role,$where)) {
            flash('انت لا تملك الصلاحيات الكافية للقيام بهذه العملية','error');
            return redirect()->route('system_admin.dashboard');
        }
        return $next($request);
    }
}
