<?php

declare(strict_types=1);

namespace App\Http\ApiSpec;

use OpenApi\Attributes as OA;

#[OA\Response(
    response: 'NotFoundResponse',
    description: 'Объект не найден',
)]
final class NotFoundResponse extends OA\Response
{
    public function __construct(string $description = null)
    {
        parent::__construct(
            response: 404,
            description: $description ?? 'Объект не найден',
        );
    }
}
