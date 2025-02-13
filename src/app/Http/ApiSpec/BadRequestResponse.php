<?php

declare(strict_types=1);

namespace App\Http\ApiSpec;

use OpenApi\Attributes as OA;

#[OA\Response(
    response: 'BadRequestResponse',
    description: 'Невалидные данные в запросе'
)]
final class BadRequestResponse extends OA\Response
{
    public function __construct(string $description = null)
    {
        parent::__construct(
            response: 400,
            description: $description ?? 'Невалидные данные в запросе',
        );
    }
}
