<?php

use App\Http\Controllers\Admin\AdminAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\NotificationController;

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])
    ->name('admin.login');

Route::post('/admin/login', [AdminAuthController::class, 'login'])
    ->name('admin.login.submit');

Route::post('/admin/logout', [AdminAuthController::class, 'logout'])
    ->name('admin.logout');

Route::get('/admin/dashboard', [AdminAuthController::class, 'dashboard'])
    ->middleware('admin')
    ->name('admin.dashboard');

Route::get('/admin/users', [UserController::class, 'index'])
    ->middleware('admin')
    ->name('admin.users.index');

Route::get('/admin/users/create', [UserController::class, 'create'])
    ->middleware('admin')
    ->name('admin.users.create');

Route::post('/admin/users', [UserController::class, 'store'])
    ->middleware('admin')
    ->name('admin.users.store');

Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])
    ->middleware('admin')
    ->name('admin.users.edit');

Route::put('/admin/users/{user}', [UserController::class, 'update'])
    ->middleware('admin')
    ->name('admin.users.update');

Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])
    ->middleware('admin')
    ->name('admin.users.destroy');

Route::post('/admin/notifications/send', [NotificationController::class, 'send'])
    ->middleware('admin')
    ->name('admin.notifications.send');