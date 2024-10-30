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
    Route::post('/password/email', [AuthController::class, 'sendResetLinkEmail']);
    Route::post('/password/reset', [AuthController::class, 'reset']);
    Route::post('/reports/test', [ReportController::class, 'testReport']);
    Route::get('/reports/{report}/download', [ReportController::class, 'download'])->middleware(HandleCors::class);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/users/export', [UserController::class, 'exportCsv']);
    Route::apiResource('users', UserController::class);
    Route::post('/users/import', [UserController::class, 'importCsv']);
    Route::post('/users/import_array', [UserController::class, 'importArray']);

    Route::get('profile', [UserController::class, 'getProfile']);
    Route::post('profile', [UserController::class, 'updateProfile']);
    Route::post('profile/password', [UserController::class, 'updatePassword']);
    Route::get('roles', [UserController::class, 'getRoles']);
    Route::get('permissions', [UserController::class, 'getPermissions']);

    Route::apiResource('projects', ProjectController::class);
    Route::get('countries', [ProjectController::class, 'getCountries']);
    Route::get('countries/{country}/cities', [ProjectController::class, 'getCities']);
    Route::get('projects/{project}/weather', [ProjectController::class, 'getProjectWeather']);
    Route::get('projects/{project}/dashboard', [DashboardController::class, 'index']);

    Route::apiResource('projects.defects', DefectController::class);
    Route::post('projects/{project}/defects/{defect}', [DefectController::class, 'update']);
    Route::get('projects/{project}/defects/filters/users', [DefectController::class, 'getUsersfilters']);
    Route::delete('defects/{defect}/attachments/{defectAttachment}', [DefectController::class, 'destroyAttachment']);

    Route::apiResource('projects.site_diaries', SiteDiaryController::class);
    Route::post('projects/{project}/site_diaries/{siteDiary}', [SiteDiaryController::class, 'update']);
    Route::delete('site_diaries/{siteDiary}/images/{siteDiaryImage}', [SiteDiaryController::class, 'destroyImage']);
    Route::post('site_diaries/{siteDiary}/comments', [SiteDiaryController::class, 'storeComment']);
    Route::post('site_diaries/{siteDiary}/comments/watch', [SiteDiaryController::class, 'toggleWatchComment']);

    Route::apiResource('projects.reports', ReportController::class);

    Route::apiResource('projects.floor_plans', FloorPlanController::class);
    Route::get('floor_plans/{floorPlan}/versions', [FloorPlanController::class, 'getVersions']);
    Route::post('floor_plans/{floorPlan}/versions', [FloorPlanController::class, 'storeVersion']);

    Route::get('notifications', [NotificationController::class, 'index']);
    Route::post('notifications/{noification}/read', [NotificationController::class, 'markAsRead']);

    Route::get('topics', [TopicController::class, 'index']);
    Route::get('topics/{topic}/questions', [TopicController::class, 'getQuestions']);
    Route::post('support', [TopicController::class, 'support']);
});
