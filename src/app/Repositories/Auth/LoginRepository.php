<?php

namespace App\Repositories\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginRepository
{
    /**
     * Проверить, совпадает ли пароль с хешем
     *
     * @param string $password
     * @param string $hashedPassword
     * @return bool
     */
    public function checkPassword(string $password, string $hashedPassword): bool
    {
        return Hash::check($password, $hashedPassword);
    }
}
