<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class Logging
{
    public function handle($request, Closure $next)
    {
        // ambil / generate session_id
        $sessionId = $this->getSessionId($request);

        // simpan ke request
        $request->attributes->set('session_id', $sessionId);

        // ===== REQUEST LOG =====
        Log::info("[$sessionId] {$request->ip()} - [{$request->method()}] {$request->getPathInfo()} REQUEST", [
            'header' => $this->filterHeaders($request->headers->all()),
            'params' => $request->query(),
            'body'   => $this->filterSensitive($request->all()),
        ]);

        // lanjut request
        $response = $next($request);

        // ===== RESPONSE LOG =====
        // Log::info("[$sessionId] {$request->ip()} - [{$request->method()}] {$request->getPathInfo()} RESPONSE", [
        //     'status_code' => $response->getStatusCode(),
        //     'response'    => method_exists($response, 'getData')
        //         ? $this->limitResponse($response->getData(true))
        //         : null,
        // ]);

        return $response;
    }

    private function getSessionId($request): string
    {
        if ($request->headers->has('X-Session-ID')) {
            return $request->header('X-Session-ID');
        }

        return substr(md5(uniqid()), 0, 10);
    }

    private function filterHeaders(array $headers): array
    {
        unset($headers['authorization']);
        unset($headers['cookie']);

        return $headers;
    }

    private function filterSensitive(array $data): array
    {
        $sensitiveKeys = ['password', 'password_confirmation', 'token'];

        foreach ($sensitiveKeys as $key) {
            if (isset($data[$key])) {
                $data[$key] = '******';
            }
        }

        return $data;
    }

    private function limitResponse($data)
    {
        if (is_array($data) && count($data) > 100) {
            return 'Too many records (' . count($data) . ')';
        }

        return $data;
    }
}
