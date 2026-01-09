<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\RequireLogin;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->name('dashboard.index')->middleware(RequireLogin::class);

Route::middleware([RequireLogin::class, 'role:super-admin|admin'])->group(function () {
    Route::get('/users', [UsersController::class, 'index'])->name('users.index')->middleware([RequireLogin::class, 'permission:view-user']);
    Route::get('/users/suggest', [UsersController::class, 'suggest'])->name('users.suggest')->middleware([RequireLogin::class, 'permission:view-user']);
    Route::get('/users/create', [UsersController::class, 'create'])->name('users.create')->middleware([RequireLogin::class, 'permission:add-user']);
    Route::post('/users', [UsersController::class, 'store'])->name('users.store')->middleware([RequireLogin::class, 'permission:add-user']);
    Route::get('/users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit')->middleware([RequireLogin::class, 'permission:edit-user']);
    Route::put('/users/{user}', [UsersController::class, 'update'])->name('users.update')->middleware([RequireLogin::class, 'permission:edit-user']);
    Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.destroy')->middleware([RequireLogin::class, 'permission:delete-user']);
});

Route::middleware([RequireLogin::class, 'role:super-admin'])->group(function () {
    Route::get('/role-permission', [RolePermissionController::class, 'index'])
        ->name('role_permission.index')->middleware([RequireLogin::class, 'permission:view-role-permission']);

    // Permissions
    Route::post('/permissions', [RolePermissionController::class, 'storePermission'])
        ->name('permissions.store')->middleware([RequireLogin::class, 'permission:add-permission']);
    Route::get('/permissions/suggest', [RolePermissionController::class, 'suggestPermission'])
        ->name('permissions.suggest')->middleware([RequireLogin::class, 'permission:view-role-permission']);
    Route::put('/permissions/{permission}', [RolePermissionController::class, 'updatePermission'])
        ->name('permissions.update')->middleware([RequireLogin::class, 'permission:edit-permission']);
    Route::delete('/permissions/{permission}', [RolePermissionController::class, 'destroyPermission'])
        ->name('permissions.destroy')->middleware([RequireLogin::class, 'permission:delete-permission']);

    // Roles
    Route::post('/roles', [RolePermissionController::class, 'storeRole'])
        ->name('roles.store')->middleware([RequireLogin::class, 'permission:add-role']);
    Route::put('/roles/{role}', [RolePermissionController::class, 'updateRole'])
        ->name('roles.update')->middleware([RequireLogin::class, 'permission:edit-role']);
    Route::delete('/roles/{role}', [RolePermissionController::class, 'destroyRole'])
        ->name('roles.destroy')->middleware([RequireLogin::class, 'permission:delete-role']);
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
