<?php

namespace App\Http\Controllers;

use App\Libraries\ChannelLog as Log;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Handle API response type
     *
     * @param array $response
     * @param int $statusCode
     * @param bool $status
     * @param string $msg
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function apiResponse($response=[],$statusCode = API_RES_STATUS_SUCCESS)
    {
        return response($response,$statusCode)->header('Content-Type', 'application/json');
    }

    public function generateError($errorCode,$errorMsg)
    {
        return [
            'errors'=>[
                [
                    "code" => $errorCode,
                    "message" => $errorMsg
                ]
            ]
        ];
    }
}
