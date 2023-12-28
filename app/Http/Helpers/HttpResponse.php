<?php

namespace App\Http\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class HttpResponse
{   
    /**
     * Success response
     * @param mixed $data
     * @param string $message
     * @param int $code
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    static function success(string $message = "Request executed successfully", $data = null, int $code = 200): JsonResponse
    {
        $data = [
            "status" => true,
            "code" => $code,
            "message" => $message,
            "data" => $data,
            "error" => null
        ];

        return Response::json($data, $code);
    } 
    
    /**
     * error response
     * @param mixed $data
     * @param string $message
     * @param int $code
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    static function error(string $message = "Fail to execute request", $data = null, int $code = 400): JsonResponse
    {

        $data = [
            "status" => false,
            "code" => $code,
            "message" => $message,
            "data" => $data,
            "error" => true
        ];

        return Response::json($data, $code);
    } 
    
    /**
     * Success response
     * @param mixed $data
     * @param string $message
     * @param int $code
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    static function severError($data = null): JsonResponse
    {
        $data = [
            "status" => false,
            "code" => 500,
            "message" => "Unexpected error occured",
            "data" => $data,
            "error" => true
        ];

        return Response::json($data, 500);
    }   
    
}
