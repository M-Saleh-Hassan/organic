<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ContractController;
use App\Http\Controllers\Admin\FinancialController;
use App\Http\Controllers\Admin\FinancialRecordController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Admin\LandController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\MediaImageController;
use App\Http\Controllers\Admin\MediaVideoController;
use App\Http\Controllers\Admin\OperationController;
use App\Http\Controllers\Admin\OperationDetailController;
use App\Http\Controllers\Admin\ProductionController;
use App\Http\Controllers\Admin\ProductionDetailController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('up');
});
Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [AuthController::class, 'resetPassword'])->name('password.update');
Route::get('password/success', function () {
    return view('auth.passwords.success');
})->name('password.success');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('admin/login', [AdminController::class, 'auth'])->name('admin.login.post');

Route::prefix('admin')->middleware(['admin'])->group(function () {
    Route::post('logout', [AdminController::class, 'logout'])->name('admin.logout');


    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('users', UserController::class, ['as' => 'admin']);
    Route::resource('lands', LandController::class, ['as' => 'admin']);
    Route::resource('contracts', ContractController::class, ['as' => 'admin']);

    Route::resource('operations', OperationController::class, ['as' => 'admin']);
    Route::resource('operations.details', OperationDetailController::class, ['as' => 'admin']);

    Route::resource('productions', ProductionController::class, ['as' => 'admin']);
    Route::resource('productions.details', ProductionDetailController::class, ['as' => 'admin']);

    Route::resource('financials', FinancialController::class, ['as' => 'admin']);
    Route::resource('financials.records', FinancialRecordController::class, ['as' => 'admin']);

    Route::resource('media', MediaController::class, ['as' => 'admin']);
    Route::resource('media.images', MediaImageController::class, ['as' => 'admin']);
    Route::resource('media.videos', MediaVideoController::class, ['as' => 'admin']);
});
