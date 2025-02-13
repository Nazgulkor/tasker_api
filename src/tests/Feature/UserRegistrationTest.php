<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Проверка успешной регистрации пользователя
     *
     * @return void
     */
    public function test_user_can_register(): void
    {
        $this->refreshDatabase();
        Artisan::call('create-roles');

        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password123',
            'role' => 'user',
            'password_confirmation' => 'password123'
        ];

        $response = $this->postJson('/api/user/register', $data);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'User registered successfully',
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'john.doe@example.com',
        ]);

        $user = User::where('email', 'john.doe@example.com')->first();
        $this->assertTrue(Hash::check('password123', $user->password));
    }

    /**
     * Проверка ошибки регистрации с некорректными данными
     *
     * @return void
     */
    public function test_registration_fails_with_invalid_data(): void
    {
        $this->refreshDatabase();
        $data = [
            'name' => '',
            'email' => 'invalid-email',
            'password' => '123',
            'role' => 'user',
            'password_confirmation' => '123'
        ];

        $response = $this->postJson('/api/user/register', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email']);
    }
}
