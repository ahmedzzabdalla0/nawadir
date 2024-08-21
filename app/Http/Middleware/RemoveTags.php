<?php

namespace App\Http\Middleware;

use Closure;

class RemoveTags
{
    protected $except = [
        //
    ];

    /**
     * Transform the given value.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        if(strtoupper($request->method()) == "POST"){
            foreach ($request->all() as $key=>$value){
                if (in_array($key, $this->except, true)) {
                    return $next($request);
                }
                if(is_string($value)){

                    if(preg_match("/(<|%3C)script[\s\S]*?(>|%3E)[\s\S]*?|(<|%3C)(\/|%2F)script[\s\S]*?(>|%3E)/",$value)){
                        return back()->withInput($request->all())->withErrors([$key=>"غير مسموح استخدام النصوص الخاصة"]);



                    }
                    if(preg_match("/^[@_!#$%^&*()<>?~:]/",$value)){
                        $value = htmlspecialchars($value);
                        $request->offsetSet($key, $value);
//                        return back()->withInput($request->all())->withErrors([$key=>"غير مسموح استخدام النصوص الخاصة"]);
                    }
                }


            }
        }

        return $next($request);


    }

}
