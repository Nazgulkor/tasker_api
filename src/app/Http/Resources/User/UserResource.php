<?php

declare(strict_types=1);

namespace App\Http\Resources\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: "Ресурс пользователя",
    description: "Ресурс пользователя",
    properties: [
        new OA\Property(
            property: "id",
            description: "ID пользователя",
            type: "integer"
        ),
        new OA\Property(
            property: "name",
            description: "Имя пользователя",
            type: "string"
        ),
        new OA\Property(
            property: "email",
            description: "Email пользователя",
            type: "string",
            format: "email"
        )
    ]
)]
/**
 * @mixin User
 */
class UserResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}
