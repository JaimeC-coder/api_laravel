<?php

namespace App\Http\Response;

use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse as HttpJsonResponse;

class JsonResponse
{
    public static function success($data, $message = 'Success', $status = true, $total = 0, $code = 200): HttpJsonResponse
    {
        return response()->json(
            [
                'data' =>  $data,
                'message' => $message,
                'status' => $status,
                'total' => $total
            ], $code
        );
    }

    public static function error($data, $message = 'Error', $status = false, $total = 0,$code = 500) : HttpJsonResponse
    {
        return response()->json(
            [
                'data' =>  $data,
                'message' => $message,
                'status' => $status,
                'total' => $total
            ], $code
        );
    }
}
