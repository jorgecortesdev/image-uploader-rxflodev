<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Psy\Util\Json;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param array $data
     * @param int $code
     * @param array $headers
     * @return JsonResponse
     */
    protected function sendJsonResponse(array $data, int $code = 200, array $headers = []): JsonResponse
    {
        $response = [
            'status' => 'success',
            'data' => $data
        ];
        return response()->json($response, $code, $headers);
    }

    /**
     * @param string $error
     * @param int $code
     * @param array $headers
     * @return JsonResponse
     */
    protected function sendJsonError(string $error, int $code = 400, array $headers = []): JsonResponse
    {
        $response = [
            'status' => 'error',
            'message' => $error
        ];
        return response()->json($response, $code, $headers);
    }
}
