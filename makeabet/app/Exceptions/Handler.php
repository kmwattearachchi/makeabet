<?php

namespace App\Exceptions;

use App\Libraries\ChannelLog as Log;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * Status code for HTTP
     *
     * @var int
     */
    protected $responseStatusCode;

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
        $message = $exception->getMessage();
        if ($exception instanceof ValidationException)
        {
            $response['errors']['validations'] = $exception->errors();
            return response(['data'=>$response])->header('Content-Type', 'application/json');
        }elseif($exception instanceof Exception){
            $response['errors'] = ERROR_MSG_UNKNOWN_ERROR;
            return response(['data'=>$response])->header('Content-Type', 'application/json');
        }

        return response(['error'=>$message],$this->responseStatusCode)->header('Content-Type', 'application/json');
    }
}
