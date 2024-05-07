<?php

namespace App\Macros;

use App\Contracts\MacroContract as Macro;
use Illuminate\Support\Facades\Response;

class ResponseMacro implements Macro
{
    /**
     * Macros for laravel json response.
     */
    public static function macros(): void
    {
        Response::macro('success', function (?string $message = 'The request resolved successfully.', ?array $data = []) {
            return Response::json([
                'title' => 'OK',
                'detail' => $message,
                'data' => $data,
            ], 200);
        });

        Response::macro('created', function (?string $message = 'The requested resource created successfully.') {
            return Response::json([
                'title' => 'OK',
                'detail' => $message,
            ], 201);
        });

        Response::macro('noContent', function () {
            return Response::json([], 204);
        });

        Response::macro('error', function (?string $message = 'The request can not be processed.') {
            return Response::json([
                'title' => 'Bad Request',
                'detail' => $message,
            ], 400);
        });

        Response::macro('forbidden', function (?string $message = 'The request can not proceed without sufficient permission.') {
            return Response::json([
                'title' => 'Forbidden',
                'detail' => $message,
            ], 403);
        });

        Response::macro('notFound', function (?string $message = 'The resource you are looking for is not found on our server.') {
            return Response::json([
                'title' => 'Not Found',
                'detail' => $message,
            ], 404);
        });

        Response::macro('thrown', function (?string $message, ?int $code) {
            if (in_array($code, [400, 403, 404])) {
                return Response::json([
                    'title' => 'Unknown',
                    'detail' => $message,
                ], $code);
            }

            return response()->error($message);
        });
    }
}
