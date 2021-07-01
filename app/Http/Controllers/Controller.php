<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param array $data
     * @return string
     */
    protected function sendResponse(array $data): string
    {
        return json_encode([
            'status' => 'success',
            'data' => $data
        ]);
    }

    /**
     * @param string $error
     * @return string
     */
    protected function sendError(string $error): string
    {
        return json_encode([
            'status' => 'error',
            'message' => $error
        ]);
    }
}
