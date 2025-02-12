<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Repositories\Auth\RegisterRepository;
use App\Repositories\User\UserRepository;
use Exception;

class RegisterService
{
    public function __construct(
        protected UserRepository $userRepository
    ) {}

    /**
     * Регистрация нового пользователя.
     *
     * @param array $data
     * @return User
     * @throws Exception
     */
    public function register(array $data): User
    {
        try {
            return $this->userRepository->create($data);
        } catch (Exception $e) {
            throw new Exception('Error creating user: ' . $e->getMessage());
        }
    }
}
