<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\DefectController;
use App\Http\Controllers\API\FloorPlanController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\ReportController;
use App\Http\Controllers\API\SiteDiaryController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\TopicController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Middleware\HandleCors;
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

    Route::get('notifications', [NotificationController::class, 'index']);
    Route::post('notifications/{noification}/read', [NotificationController::class, 'markAsRead']);
});
