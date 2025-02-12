<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\TaskController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;



Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user', [UserController::class, 'show']);
    Route::put('/user', [UserController::class, 'update']);
    Route::get('/users', [UserController::class, 'users'])->middleware(['can:view all users']);
    Route::delete('/user/{id}', [UserController::class, 'delete'])->middleware(['can:delete user']);

    Route::get('/task/{id}', [TaskController::class, 'show']);
    Route::delete('/task/{id}', [TaskController::class, 'delete']);
    Route::get('/tasks', [TaskController::class, 'tasks']);
    Route::post('/task', [TaskController::class, 'create'])->middleware(['role:admin']);
    Route::put('/task/{id}', [TaskController::class, 'update']);
});

Route::post('/user/register', [RegisterController::class, 'register']);
Route::post('/user/login', [LoginController::class, 'login']);
