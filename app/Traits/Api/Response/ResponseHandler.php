<?php

namespace App\Traits\Api\Response;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ResponseHandler
{
    /**
     * Standardized API response format.
     */
    public function apiResponse(mixed $data = null, string $message = "null", int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'success' => $statusCode >= 200 && $statusCode < 300,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Handle a successful API response.
     */
    public function respondSuccess(mixed $data = null, string $message = null): JsonResponse
    {
        if (!$message) {
            $message = __('main.successful');
        }

        return $this->apiResponse($data, $message, Response::HTTP_OK);
    }

    /**
     * Handle an error API response.
     */
    public function respondError(string $message = null, int $statusCode = Response::HTTP_BAD_REQUEST, mixed $errors = null): JsonResponse {
        if (!$message) {
            $message = __('main.bad_request');
        }

        $responseData = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors) {
            $responseData['errors'] = $errors;
        }

        return response()->json($responseData, $statusCode);
    }
}
