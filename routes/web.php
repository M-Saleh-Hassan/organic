<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\FinancialController;
use App\Http\Controllers\Admin\FinancialRecordController;
use App\Http\Controllers\API\AuthController;
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

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('login', [AdminController::class, 'auth'])->name('admin.login.post');
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('users', [AdminController::class, 'users'])->name('admin.users');

    Route::resource('financials', FinancialController::class, ['as' => 'admin']);
    Route::resource('financials.records', FinancialRecordController::class, ['as' => 'admin'])->shallow();

});
