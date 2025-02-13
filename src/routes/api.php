<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Task\TaskController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], static function () {
    Route::get('/users/show', [UserController::class, 'show']);
    Route::put('/users/update', [UserController::class, 'update']);
    Route::get('/users', [UserController::class, 'index'])->middleware(['role:admin']);
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->middleware(['role:admin']);

    Route::apiResource('tasks', TaskController::class);
});

Route::post('/user/register', [RegisterController::class, 'register']);
Route::post('/user/login', [LoginController::class, 'login']);
