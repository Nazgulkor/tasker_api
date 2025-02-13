<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use App\Http\Resources\User\UserResource;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {
    }

    public function show(Request $request): JsonResponse
    {
        $user = $this->userService->getAuthUser($request);

        return response()->json(['data' => new UserResource($user)]);
    }

    public function users(): JsonResponse
    {
        $users = $this->userService->getAllUsers();

        return response()->json([
            'data' => UserResource::collection($users)
        ]);
    }

    public function update(UserRequest $request): JsonResponse
    {
        $userId = Auth::id();

        if (!$userId) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $updatedUser = $this->userService->updateUser($userId, $request->validated());

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => new UserResource($updatedUser)
        ]);
    }

    public function delete(int $id): JsonResponse
    {
        $authUserId = Auth::id();

        if ($authUserId === $id) {
            return response()->json(['message' => 'Администратор не может удалить себя.'], 403);
        }

        $this->userService->deleteUser($id);

        return response()->json(['message' => 'Пользователь успешно удален.']);
    }
}
