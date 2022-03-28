<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('test', function () {
    $authUser = auth()->user();
    $role = 'admin';
    dd($role == 'admin' &&  $authUser->role == 'admin');
});

// Homepage
Route::get('/', [UsersController::class, 'index'])->name('homepage');
Route::get('/users', [UsersController::class, 'index'])->name('homepage');
// Login & Registration
Route::middleware('guest')->group(function() {
    // Registration
    Route::get('/registration', [RegistrationController::class, 'showRegistration'])->name('registration');
    Route::post('/registration', [RegistrationController::class, 'registrate'])->name('registrate');

    // Auth
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'makeLogin'])->name('login');
});

// Logout
Route::get('/logout', [LogoutController::class, 'make'])->name('logout');

// Users pages
Route::prefix('user')->group(function () {
    // Profile
    Route::get('{user}', [UsersController::class, 'profile'])->name('profile')->middleware('auth:auth');
    // EditMainInfo
    Route::get('{user}/edit', [UsersController::class, 'mainInfo'])->middleware('auth:owner')->name('editMainInfo');
    Route::post('{user}/edit', [UsersController::class, 'storeMainInfo'])->middleware('auth:owner')->name('storeMainInfo');
    // EditSecurity
    Route::get('{user}/security', [UsersController::class, 'security'])->middleware('auth:owner')->name('editSecurity');
    Route::post('{user}/security', [UsersController::class, 'storeSecurity'])->middleware('auth:owner')->name('storeSecurity');
    // Avatar
    Route::get('{user}/avatar', [UsersController::class, 'avatar'])->middleware('auth:owner')->name('avatar');
    Route::post('{user}/avatar', [UsersController::class, 'storeAvatar'])->middleware('auth:owner')->name('storeAvatar');
    // Status
    Route::get('{user}/status', [UsersController::class, 'status'])->middleware('auth:owner')->name('status');
    Route::post('{user}/status', [UsersController::class, 'storeStatus'])->middleware('auth:owner')->name('status');
    // Delete
    Route::get('{user}/delete', [UsersController::class, 'deleteProfile'])->middleware('auth:owner')->name('deleteProfile');
});

//Administration
Route::get('/admin/new_user', [AdminController::class, 'newUser'])->middleware('auth:admin')->name('newUser');
Route::post('/admin/new_user', [AdminController::class, 'storeNewUser'])->middleware('auth:admin')->name('storeNewUser');

