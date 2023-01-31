<?php

namespace App\Helpers;

class ResponseHelper
{
    static function response($data = null ,$message = 'Success' ,$status = 200)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
        ],$status);
    }
}