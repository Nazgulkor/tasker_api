<?php

declare(strict_types=1);

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class SuccessResponse extends JsonResponse
{
    public function __construct(array $data = null, int $status = 200)
    {
        $jsonData['success'] = true;

        if (!empty($data)) {
            $jsonData['data'] = $data;
        }

        parent::__construct($jsonData, $status);
    }
}
