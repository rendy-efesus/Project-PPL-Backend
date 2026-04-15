<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ResponseHelper
{
    public static function success($data = null, string $message = 'Success', int $code = 200): JsonResponse
    {
        $response = [
            'status'  => true,
            'code'    => $code,
            'message' => $message,
            'data'    => self::normalizeData($data),
        ];

        self::log($response);

        return response()->json($response, $code);
    }

    public static function error($message = 'Error', int $code = 400, $data = null): JsonResponse
    {
        $response = [
            'status'  => false,
            'code'    => $code,
            'message' => $message,
            'data'    => self::normalizeData($data),
        ];

        self::log($response);

        return response()->json($response, $code);
    }

    private static function normalizeData($data)
    {
        if (is_array($data) && empty($data)) {
            return null;
        }

        return $data;
    }

    private static function log($response): void
    {
        $sessionId = self::getSessionId();

        $request = request();

        $requestData = [
            'params' => $request->query(),
            'body'   => self::filterSensitive($request->all()),
        ];

        Log::info("[$sessionId] {$request->ip()} - [{$request->method()}] {$request->getPathInfo()} RESPONSE", [
            'status'   => $response['status'],
            'code'     => $response['code'],
            'message'  => $response['message'],
            'request'  => $requestData,
            'response' => self::limitResponse($response['data']),
        ]);
    }

    private static function getSessionId(): string
    {
        if (request()->attributes->has('session_id')) {
            return request()->attributes->get('session_id');
        }

        return substr(md5(uniqid()), 0, 10);
    }

    private static function filterSensitive(array $data): array
    {
        $sensitiveKeys = ['password', 'password_confirmation', 'token'];

        foreach ($sensitiveKeys as $key) {
            if (isset($data[$key])) {
                $data[$key] = '******';
            }
        }

        return $data;
    }

    private static function limitResponse($data)
    {
        if (is_array($data) && count($data) > 100) {
            return 'Too many records (' . count($data) . ')';
        }

        return $data;
    }
}
