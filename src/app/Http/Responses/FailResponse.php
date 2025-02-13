<?php

declare(strict_types=1);

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class FailResponse extends JsonResponse
{
    public function __construct(string $message, $status = 400)
    {
        $jsonData = [
            'success' => false,
            'message' => $message
        ];

        parent::__construct($jsonData, $status);
    }
}