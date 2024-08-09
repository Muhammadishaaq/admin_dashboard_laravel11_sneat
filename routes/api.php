<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\{
    UserController,
   
};



Route::post('/user/register', [UserController::class, 'register'])->name('user.register');
Route::post('/user/login',    [UserController::class, 'login'])->name('user.login');

Route::middleware(['auth:sanctum'])->prefix('user')->group( function () {
    Route::post('/update/profile',    [UserController::class, 'update_profile'])->name('user.profile');
    Route::post('/update/password',    [UserController::class, 'update_password'])->name('user.password');
});