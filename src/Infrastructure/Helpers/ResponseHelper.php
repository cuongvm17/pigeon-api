<?php

namespace Pigeon\Infrastructure\Helpers;

use Illuminate\Http\JsonResponse;

/**
 * Class ResponseHelper
 * @package Pigeon\Infrastructure\Helpers
 */
trait ResponseHelper
{
    /**
     * @param string $message
     * @param array $data
     * @param array $options
     * @return JsonResponse
     */
    public function sendSuccess(string $message, array $data = [], array $options = []): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message
        ];

        $response['data'] = $data;

        if ($options) {
            $response = array_merge($response, $options);
        }

        return response()->json($response);
    }

    /**
     * @param string $message
     * @param int $httpCode
     * @param int $messageCode
     * @param array $errors
     * @param array $options
     * @return JsonResponse
     */
    public function sendError(
        string $message,
        int $httpCode = 500,
        array $errors = [],
        array $options = []
    ): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        if (!empty($options)) {
            $response = array_merge($response, $options);
        }

        if (empty($httpCode) || $httpCode > 500) {
            $httpCode = 500;
        }

        $response['errorCode'] = $httpCode;

        if ($httpCode === 500) {
            $response['message'] = 'Internal server error!';
        }

        return response()->json($response, $httpCode);
    }
}