<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\ApiSpec;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Responses\SuccessResponse;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use OpenApi\Attributes as OA;

final class RegisterController
{
    #[OA\Post(
        path: '/api/user/register',
        summary: 'Регистрация пользователя',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                ref: RegisterRequest::class
            )
        ),
        tags: ['Auth'],
        responses: [
            new ApiSpec\SuccessResponse(
                properties: [
                    new OA\Property(
                        property: 'user',
                        ref: UserResource::class
                    ),
                ],
            ),
            new ApiSpec\BadRequestResponse(),
        ]
    )]
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::factory()->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $request->is_admin ? $user->assignRole('admin') : $user->assignRole('user');

        return new SuccessResponse(['user' => new UserResource($user)]);
    }
}
