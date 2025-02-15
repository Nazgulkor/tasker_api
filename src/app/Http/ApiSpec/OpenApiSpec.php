<?php

declare(strict_types=1);

namespace App\Http\ApiSpec;

use OpenApi\Attributes as OA;

#[OA\Info(version: '1.0', title: 'Tasker API')]
#[OA\Server(
    url: 'http://localhost',
    description: 'Tasker API documentation'
)]
#[OA\SecurityScheme(
    securityScheme: 'bearerAuth',
    type: 'http',
    bearerFormat: 'JWT',
    scheme: 'bearer'
)]
final class OpenApiSpec {}
