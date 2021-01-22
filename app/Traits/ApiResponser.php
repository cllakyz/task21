<?php


namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponser
{
    /**
     * Success response method.
     *
     * @param $result
     * @param $message
     * @param $statusCode
     * @return JsonResponse
     */
    public function successResponse($result, $message, $statusCode = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json(
            $response,
            $statusCode,
            ['Content-Type' => 'application/json; charset=UTF-8;', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE);
    }

    /**
     * Error response method.
     *
     * @param $error
     * @param $messages
     * @param $statusCode
     * @return JsonResponse
     */
    public function errorResponse($error, $messages = [], $statusCode = 404): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($messages)) {
            $response['errors'] = $messages;
        }

        return response()->json(
            $response,
            $statusCode,
            ['Content-Type' => 'application/json; charset=UTF-8;', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE);
    }
}
