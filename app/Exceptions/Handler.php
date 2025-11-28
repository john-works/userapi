<?php

namespace App\Exceptions;

use app\Helpers\AppConstants;
use app\Helpers\DataLoader;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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

//        try{
//
//            /*
//             * This error is weird you need to look into it's cause
//             * */
//            if(!str_contains(strtolower($exception->getMessage()), strtolower('Method [send] does NOT exist ON view.'))){
//
//                $data = [
//                    'error_message' => 'PORTAL-ERROR ' . $exception->getMessage(),
//                    'error_code' => $exception->getCode(),
//                    'line_number' => $exception->getLine(),
//                    'stack_trace' => $exception->getTraceAsString(),
//                    'class_name' => __CLASS__,
//                    'method' => __METHOD__,
//                ];
//               // $resp = DataLoader::saveErrorLog($data);
//
//            }
//
//
//        }catch (\Exception $exception){
//
//        }finally{
//            parent::report($exception);
//        }

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

        if(!AppConstants::IN_DEBUG && ! ($exception instanceof ValidationException) ){
            $error = AppConstants::generalError($exception->getMessage());
            return view('errors.500', compact('error'));
        }

        return parent::render($request, $exception);

    }
}
