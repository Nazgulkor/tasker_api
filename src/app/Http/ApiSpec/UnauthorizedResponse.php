<?php

declare(strict_types=1);

namespace App\Http\ApiSpec;

use OpenApi\Attributes as OA;

#[OA\Response(
    response: 'UnauthorizedResponse',
    description: 'Необходима авторизация',
)]
final class UnauthorizedResponse extends OA\Response
{
    public function __construct(string $description = null)
    {
        parent::__construct(
            response: 401,
            description: $description ?? 'Необходима авторизация',
        );
    }
}
