<?php

namespace App\Http\Middleware;

use Closure;

class DeleteTempIMGS
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
        $response = $next($request);
        //  self::deleteTEMP();

        return $response;
    }
    public static function deleteTEMP(){
//        echo 'runned';

        $currentRoute=\Illuminate\Support\Facades\Route::current();
        if(isset($currentRoute->action['controller'])){
            $currentMode=$currentRoute->action['controller'];
            $currentprefix=$currentRoute->action['prefix'];
            // session(['tempImage'=>[]]);
            if(str_contains($currentprefix,'admin')){
                if(str_contains($currentMode,'index')){
                    // session(['tempImage'=>[]]);
                    $temp=session('tempImage');

                    if(is_array($temp))
                        foreach ($temp as $t){
                            try{
                                unlink("./uploads/".$t);
                                unlink("./uploads/thumbnail/".$t);

                            }catch (\Exception $e){}
                        }
                    session(['tempImage'=>[]]);

                    $temp=session('tempMultiImage');
                    if(is_array($temp))
                        foreach ($temp as $t){
                            try{
                                unlink("./uploads/".$t);
                                unlink("./uploads/thumbnail/".$t);

                            }catch (\Exception $e){}
                        }
                    session(['tempMultiImage'=>[]]);
                    return true;
                }
            }}


        return true;
    }
}
