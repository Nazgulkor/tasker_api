<?php

declare(strict_types=1);

namespace App\Http\ApiSpec;

use OpenApi\Attributes as OA;

#[OA\Response(
    response: 'SuccessResponse',
    description: 'Операция успешна'
)]
final class SuccessResponse extends OA\Response
{
    public function __construct(
        string $ref = null,
        array $properties = null,
        OA\Items $items = null,
        bool $nullableData = false,
    ) {
        parent::__construct(
            response: 200,
            description: 'Операция успешна',
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: 'data',
                        ref: $ref,
                        properties: $properties,
                        type: null === $items ? 'object' : 'array',
                        items: $items,
                        nullable: $nullableData || (null === $items && null === $properties && null === $ref),
                    ),
                    new OA\Property(
                        property: 'success',
                        type: 'boolean',
                    ),
                ],
                type: 'object',
            ),
        );
    }
}
