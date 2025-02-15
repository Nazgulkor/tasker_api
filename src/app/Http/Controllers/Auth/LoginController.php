<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\ApiSpec;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Responses\FailResponse;
use App\Http\Responses\SuccessResponse;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Auth', description: 'Авторизация')]
final class LoginController
{
    #[OA\Get(
        path: '/api/user/login',
        summary: 'Login user',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                ref: LoginRequest::class
            )
        ),
        tags: ['Auth'],
        responses: [
            new ApiSpec\SuccessResponse(properties: [
                new OA\Property(
                    property: 'token',
                    type: 'string',
                ),
            ]),
            new ApiSpec\NotFoundResponse(),
            new ApiSpec\BadRequestResponse()
        ],
    )]
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $user = User::whereEmail($request->email)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return new FailResponse('Пользователь не найден', 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return new FailResponse('Неверные учетные данные', 400);
        }

        $token = $user->createToken(name: config('app.name'), expiresAt: now()->addWeek());

        return new SuccessResponse(['token' => $token->plainTextToken]);
    }
}
