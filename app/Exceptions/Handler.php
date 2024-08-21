<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => $exception->getMessage()], 401);
        }
        $guard = Arr::get($exception->guards(), 0);
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

        return redirect()->guest(route($login));
    }

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(\Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, \Throwable $exception)
    {
        if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
            return redirect()->route('website.error419');
        }
        return parent::render($request, $exception);
    }



    protected function invalidJson($request, ValidationException $exception)

    {
        $err=[];
        foreach ($exception->errors() as $key=>$value){
            $col=collect($value);
            $n= new \stdClass();
            $n->field=$key;
            $n->error=$col->first();
            $err[]=$n;
        }

        return response()->json([

            "status"=>false,

            'response_message' => trans('api_texts.validation_error'),

            'errors' => $err,

            'data'=>null

        ], $exception->status);

    }


}
