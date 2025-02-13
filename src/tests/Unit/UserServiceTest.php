<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Services\User\UserService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Mockery;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $userService;
    private $userRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepositoryMock = Mockery::mock(UserRepository::class);
        $this->userService = new UserService($this->userRepositoryMock);
    }

    public function test_getAuthUser_returns_authenticated_user()
    {
        $mockedUser = Mockery::mock(User::class);
        $requestMock = Mockery::mock(Request::class);
        $requestMock->shouldReceive('user')->andReturn($mockedUser);

        $user = $this->userService->getAuthUser($requestMock);

        $this->assertSame($mockedUser, $user);
    }

    public function test_getAllUsers_returns_users_from_repository()
    {
        $usersCollection = Mockery::mock(Collection::class);
        $this->userRepositoryMock->shouldReceive('getAllUsers')->andReturn($usersCollection);

        $users = $this->userService->getAllUsers();

        $this->assertSame($usersCollection, $users);
    }

    public function test_deleteUser_throws_exception_if_user_not_found()
    {
        $this->userRepositoryMock->shouldReceive('getById')->with(999)->andReturn(null);

        $this->expectException(ModelNotFoundException::class);

        $this->userService->deleteUser(999);
    }

    public function test_updateUser_does_not_update_password_if_not_given()
    {
        $user = Mockery::mock(User::class);
        $this->userRepositoryMock->shouldReceive('getById')->with(1)->andReturn($user);
        $this->userRepositoryMock->shouldReceive('updateUser')->with($user, Mockery::on(function ($data) {
            return !isset($data['password']);
        }))->once();

        $data = ['name' => 'Updated Name'];

        $updatedUser = $this->userService->updateUser(1, $data);

        $this->assertInstanceOf(User::class, $updatedUser);
    }
}
