<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function sendResponse($result, $message, $code = 200)
    {
        $response = [
            'success' => true,
            'code' => $code,
            'message' => $message,
            'data' => $result
        ];

        return response()->json($response, $code);
    }

    protected function sendError($error, $errorMessages = [], $code = 400)
    {
        $response = [
            'success' => false,
            'message' => $error
        ];

        if (!empty($errorMessages)) $response['data'] = $errorMessages;

        return response()->json($response, $code);
    }
}
