<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function sendOkResponse($data, $key = 'data', $statusCode = Response::HTTP_OK) {
        return response()->json([
            $key => $data
        ], $statusCode);
    }

    protected function sendCreatedResponse($message, $data, $key = 'data', $statusCode = Response::HTTP_CREATED) {
        return response()->json([
            'message' => $message,
            $key => $data
        ], $statusCode);
    }

    protected function sendNotFoundResponse($message, $statusCode = Response::HTTP_NOT_FOUND) {
        return response()->json([
            'error' => $message
        ], $statusCode);
    }

    protected function sendBadRequestResponse($message, $statusCode = Response::HTTP_BAD_REQUEST) {
        return response()->json([
            'error' => $message
        ], $statusCode);
    }
}
