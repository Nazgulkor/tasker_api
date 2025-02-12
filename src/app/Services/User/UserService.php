<?php

namespace App\Services\User;

use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        private UserRepository $userRepository
    ){ }

    public function getAuthUser(Request $request): User
    {
        return $request->user();
    }

    public function getAllUsers(): Collection
    {
        return $this->userRepository->getAllUsers();
    }

    public function deleteUser(int $userId): void
    {
        $user = $this->userRepository->getById($userId);

        if (!$user) {
            throw new ModelNotFoundException("Пользователь с ID {$userId} не найден.");
        }

        $user->delete();
    }

    public function updateUser(int $user, array $data): User
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user = $this->userRepository->getById($user);

        $this->userRepository->updateUser($user, $data);

        return $user;
    }
}
