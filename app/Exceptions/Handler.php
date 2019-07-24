<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
//        if(config('app.debug')){
//            return parent::render($request, $exception);
//        }
        return $this->handle($request, $exception);
    }
    public function handle($request, Exception $e){
        // 只处理自定义的APIException异常
        if($e instanceof ApiException) {
            $result = [
                "msg"    => $e->getMessage(),
                "data"   => $e->get_e_data(),
                "status" => $e->getCode()
            ];
            return response()->json($result);
        }
        return parent::render($request, $e);
    }
}
