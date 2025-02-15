<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\ApiSpec;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Responses\FailResponse;
use App\Http\Responses\SuccessResponse;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Users', description: 'Пользователи')]
class UserController
{
    #[OA\Get(
        path: '/api/users',
        summary: 'Получение списка пользователей',
        security: [
            ['bearerAuth' => []]
        ],
        tags: ['Users'],
        responses: [
            new ApiSpec\SuccessResponse(
                properties: [
                    new OA\Property(
                        property: 'users',
                        type: 'array',
                        items: new OA\Items(
                            ref: UserResource::class
                        )
                    ),
                ],
            ),
            new ApiSpec\ForbiddenResponse(),
            new ApiSpec\UnauthorizedResponse(),
        ]
    )]
    public function index(): JsonResponse
    {
        return new SuccessResponse(['users' => UserResource::collection(User::all())]);
    }

    #[OA\Get(
        path: '/api/users/show',
        summary: 'Получение информации о пользователе',
        security: [
            ['bearerAuth' => []]
        ],
        tags: ['Users'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(
                    type: 'integer'
                )
            ),
        ],
        responses: [
            new ApiSpec\SuccessResponse(
                properties: [
                    new OA\Property(
                        property: 'user',
                        ref: UserResource::class
                    ),
                ],
            ),
            new ApiSpec\NotFoundResponse(),
            new ApiSpec\UnauthorizedResponse(),
        ]
    )]
    public function show(): JsonResponse
    {
        return new SuccessResponse(['user' => new UserResource(Auth::user())]);
    }

    #[OA\Put(
        path: '/api/users/update',
        summary: 'Обновление информации о пользователе',
        security: [
            ['bearerAuth' => []]
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                ref: UpdateUserRequest::class
            )
        ),
        tags: ['Users'],
        responses: [
            new ApiSpec\SuccessResponse(
                properties: [
                    new OA\Property(
                        property: 'user',
                        ref: UserResource::class
                    ),
                ],
            ),
            new ApiSpec\NotFoundResponse(),
            new ApiSpec\UnauthorizedResponse(),
        ]
    )]
    public function update(UpdateUserRequest $request): JsonResponse
    {
        $user = User::whereId(Auth::id())->first();
        $user->update($request->toArray());
        $user->refresh();

        return new SuccessResponse(['user' => new UserResource($user)]);
    }

    #[OA\Delete(
        path: '/api/users/{id}',
        summary: 'Удаление пользователя',
        security: [
            ['bearerAuth' => []]
        ],
        tags: ['Users'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(
                    type: 'integer'
                )
            ),
        ],
        responses: [
            new ApiSpec\SuccessResponse(),
            new ApiSpec\NotFoundResponse(),
            new ApiSpec\ForbiddenResponse(),
        ]
    )]
    public function destroy(int $id): JsonResponse
    {
        if (Auth::id() === $id) {
            return new FailResponse('Вы не можете удалите собственного пользователя', 403);
        }
        try {
            $user = User::whereId($id)->firstOrFail();
        } catch (ModelNotFoundException) {
            return new FailResponse('Пользователь не найден', 404);
        }

        $user->delete();

        return new SuccessResponse();
    }
}
