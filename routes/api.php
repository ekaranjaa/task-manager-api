<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvailabilitiesController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\UsersController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('email')->group(function () {
    Route::get('verify', function () {
        return response()->json(['message' => 'Email not verified.']);
    })->name('verification.notice');

    Route::get('verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return response()->json(['message' => 'Email verified successfully.']);
    })->middleware('signed')->name('verification.verify');

    Route::post('verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return response()->json(['message' => 'Verification email resent.']);
    })->middleware('throttle:6,1')->name('verification.send');
});

Route::middleware('auth:sanctum')->prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login'])
        ->withoutMiddleware('auth:sanctum');
    Route::post('register', [AuthController::class, 'register'])
        ->withoutMiddleware('auth:sanctum');
    Route::get('user', [AuthController::class, 'index']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::put('update', [AuthController::class, 'update']);
    Route::put('update-password', [AuthController::class, 'updatePassword']);
    Route::delete('delete', [AuthController::class, 'delete']);

    Route::prefix('availability')->group(function () {
        Route::post('create', [AvailabilitiesController::class, 'create']);
        Route::put('update', [AvailabilitiesController::class, 'update']);
    });
});

Route::middleware('auth:sanctum')->prefix('roles')->group(function () {
    Route::get('/', [RolesController::class, 'index']);
    Route::post('create', [RolesController::class, 'create']);
    Route::put('update/{id}', [RolesController::class, 'update']);
    Route::delete('delete/{id}', [RolesController::class, 'delete']);
});

Route::middleware('auth:sanctum')->prefix('users')->group(function () {
    Route::get('/', [UsersController::class, 'index']);
    Route::get('search/{query}', [UsersController::class, 'search']);
    Route::put('update/{id}', [UsersController::class, 'update']);
    Route::put('update-permission/{id}', [UsersController::class, 'updatePermission']);
    Route::delete('delete/{id}', [UsersController::class, 'delete']);
});

Route::middleware('auth:sanctum')->prefix('tasks')->group(function () {
    Route::get('/', [TasksController::class, 'index']);
    Route::get('search/{query}', [TasksController::class, 'search']);
    Route::post('create', [TasksController::class, 'create']);
    Route::put('update/{id}', [TasksController::class, 'update']);
    Route::put('assign/{id}', [TasksController::class, 'assign']);
    Route::put('close/{id}', [TasksController::class, 'close']);
    Route::delete('delete/{id}', [TasksController::class, 'delete']);
});
