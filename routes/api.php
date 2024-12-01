<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ContractController;
use App\Http\Controllers\API\FinancialController;
use App\Http\Controllers\API\LandController;
use App\Http\Controllers\API\MediaController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\OperationController;
use App\Http\Controllers\API\ProductionController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/password/email', [AuthController::class, 'sendResetLinkEmail']);
    Route::post('/password/reset', [AuthController::class, 'reset']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('users', UserController::class);

    Route::get('profile', [UserController::class, 'getProfile']);
    Route::post('profile', [UserController::class, 'updateProfile']);
    Route::post('profile/password', [UserController::class, 'updatePassword']);
    Route::get('roles', [UserController::class, 'getRoles']);

    Route::get('lands', [LandController::class, 'index']);
    Route::get('lands/{land}', [LandController::class, 'show']);

    Route::get('contracts', [ContractController::class, 'index']);
    Route::get('contracts/{contract}', [ContractController::class, 'show']);

    Route::get('operations', [OperationController::class, 'index']);
    Route::get('operations/{operation}', [OperationController::class, 'show']);

    Route::get('productions', [ProductionController::class, 'index']);
    Route::get('productions/{production}', [ProductionController::class, 'show']);

    Route::get('financials', [FinancialController::class, 'index']);
    Route::get('financials/{financial}', [FinancialController::class, 'show']);

    Route::get('media', [MediaController::class, 'index']);
    Route::get('media/{media}', [MediaController::class, 'show']);

    Route::get('notifications', [NotificationController::class, 'index']);
    Route::post('notifications/{noification}/read', [NotificationController::class, 'markAsRead']);
});
