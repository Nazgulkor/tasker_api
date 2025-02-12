<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    /**
     * Найти пользователя по email
     *
     * @param string $email
     * @return User|null
     */
    public function findUserByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    /**
     * Создание нового пользователя.
     *
     * @param array $data
     * @return User
     */
    public function create(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function getAllUsers(): Collection
    {
        return User::with('tasks')->get();
    }

    public function getById(int $id): ?User
    {
        return User::find($id);
    }

    public function updateUser(User $user, array $data): Bool
    {
        return $user->update($data);
    }
}
