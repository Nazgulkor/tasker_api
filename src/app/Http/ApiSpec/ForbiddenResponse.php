<?php

declare(strict_types=1);

namespace App\Http\ApiSpec;

use OpenApi\Attributes as OA;

#[OA\Response(
    response: 'ForbiddenResponse',
    description: 'Операция запрещена',
)]
final class ForbiddenResponse extends OA\Response
{
    public function __construct(string $description = null)
    {
        parent::__construct(
            response: 403,
            description: $description ?? 'Операция запрещена',
        );
    }
}
