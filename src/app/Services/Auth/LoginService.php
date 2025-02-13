<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Models\User;
use App\Repositories\Auth\LoginRepository;
use App\Repositories\User\UserRepository;

final readonly class LoginService
{
    public function __construct(
        private UserRepository $userRepository,
        private LoginRepository $loginRepository,
    ) {
    }

    public function login(array $credentials): ?string
    {
        /**
         * @var User $user
         */
        $user = $this->userRepository->findUserByEmail($credentials['email']);

        if (!$user || !$this->loginRepository->checkPassword($credentials['password'], $user->password)) {
            return null;
        }

        return $user->createToken(
            name: config('app.name'),
            expiresAt: now()->addWeek(),
        )->plainTextToken;
    }
}
