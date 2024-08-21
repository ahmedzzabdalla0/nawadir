<?php
namespace App\Http\Middleware;
use App\Http\Controllers\ControllersService;
use App\Models\Artist;
use App\Models\Driver;
use App\Models\Teacher;
use App\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Str;

class APIauth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next,$type='user')
    {
        if($type == 'user'){
            if ($request->token && $request->user_id) {
                if ($user = User::find($request->user_id)) {
                    if ($user->token == $request->token) {
                        if ($user->status == 1) {
                            return $next($request);
                        } elseif ($user->status == 0) {
                            return ControllersService::generateArraySuccessResponse(['user_data' => User::find($user->id)], 'user_not_activated', null, 422);
                        } else {
                            return ControllersService::generateGeneralResponse(false, 'user_blocked', null, 400);
                        }
                    } else {
                        return ControllersService::generateGeneralResponse(false, 'token_mismatch', null, 400);
                    }
                }else {
                    return ControllersService::generateGeneralResponse(false, 'user_not_found', null, 400);
                }
            }elseif($request->headers->get("X-Authorization")){
                $token=Str::after($request->headers->get("X-Authorization"),'Bearer ');
                if ($user = User::where('token',$token)->first()) {
                    if(!$request->user_id){
                        $request->offsetSet('user_id', $user->id);
                    }
                    if ($user->status == 1) {

                        return $next($request);
                    } elseif ($user->status == 0) {
                        return ControllersService::generateArraySuccessResponse(['user_data' => User::find($user->id)], 'user_not_activated', null, 422);
                    } else {
                        return ControllersService::generateGeneralResponse(false, 'user_blocked', null, 400);
                    }

                }else {
                    return ControllersService::generateGeneralResponse(false, 'user_not_found', null, 400);
                }

            }else {
                return ControllersService::generateGeneralResponse(false, 'token_not_found', null, 400);
            }
        }
        if($type == 'driver'){
            if ($request->token && $request->user_id) {
                if ($user = Driver::find($request->user_id)) {
                    if ($user->token == $request->token) {
                        if ($user->status == 1) {
                            return $next($request);
                        } elseif ($user->status == 0) {
                            return ControllersService::generateArraySuccessResponse(['user_data' => User::find($user->id)], 'user_not_activated', null, 422);
                        } else {
                            return ControllersService::generateGeneralResponse(false, 'user_blocked', null, 400);
                        }
                    } else {
                        return ControllersService::generateGeneralResponse(false, 'token_mismatch', null, 400);
                    }
                }else {
                    return ControllersService::generateGeneralResponse(false, 'user_not_found', null, 400);
                }
            }elseif($request->headers->get("X-Authorization")){
                $token=Str::after($request->headers->get("X-Authorization"),'Bearer ');
                if ($user = Driver::where('token',$token)->first()) {
                    if(!$request->user_id){
                        $request->offsetSet('user_id', $user->id);
                    }
                    if ($user->status == 1) {

                        return $next($request);
                    } elseif ($user->status == 0) {
                        return ControllersService::generateArraySuccessResponse(['user_data' => User::find($user->id)], 'user_not_activated', null, 422);
                    } else {
                        return ControllersService::generateGeneralResponse(false, 'user_blocked', null, 400);
                    }

                }else {
                    return ControllersService::generateGeneralResponse(false, 'user_not_found', null, 400);
                }

            }else {
                return ControllersService::generateGeneralResponse(false, 'token_not_found', null, 400);
            }
        }
        return ControllersService::generateGeneralResponse(false, 'user_not_found', null, 400);
    }
}
