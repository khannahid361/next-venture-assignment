<?php

use App\Http\Controllers\API\BlogPostController;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Http\Controllers\AuthorizationController;
use Laravel\Passport\Http\Controllers\TransientTokenController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\UserPermissionController;
use App\Http\Controllers\API\UserRoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

//setup
Route::get('run-migrations', function () {
    try {
        Artisan::call('migrate');
        return "Migrations ran successfully!";
    } catch (Exception $e) {
        return "Error: " . $e->getMessage();
    }
})->name('run.migrations');

Route::get('run-all-seeders', function () {
    if (app()->environment('production')) {
        abort(403, 'Seeders cannot be executed in production!');
    }
    
    Artisan::call('db:seed');
    return response()->json(['message' => 'All seeders executed successfully!']);
});

Route::group(['prefix' => 'api'], function () {
    Route::post('/token', [AccessTokenController::class, 'issueToken'])->name('passport.token');
    Route::post('/token/refresh', [TransientTokenController::class, 'refresh'])->name('passport.token.refresh');
    Route::get('/authorize', [AuthorizationController::class, 'authorize'])->name('passport.authorize');
});
//end setup

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);
Route::middleware('auth:api')->group(function () {
    Route::get('logout', [RegisterController::class, 'logout']);
});

Route::middleware(['auth:api'])->group(function () {
    // Routes that require 'permission:create-user'
    Route::middleware(['permission:create-user'])->group(function () {
        Route::post('add-user', [UserController::class, 'store']);
        Route::post('add-user-role', [UserRoleController::class, 'assignUserRole']);
        Route::post('add-user-permission', [UserPermissionController::class, 'assignUserPermission']);
    });

    // Routes that require 'permission:view-user'
    Route::middleware(['permission:view-user-list'])->group(function () {
        Route::get('all-users', [UserController::class, 'index']);
    });

    Route::middleware(['permission:view-user'])->group(function () {
        Route::get('user/{id}', [UserController::class, 'show']);
    });

    Route::middleware(['permission:edit-user'])->group(function () {
        Route::put('edit-user/{id}', [UserController::class, 'update']);
    });

    Route::middleware(['permission:delete-user'])->group(function () {
        Route::get('delete-user/{id}', [UserController::class, 'destroy']);
    });

    Route::middleware(['permission:view-role-list'])->group(function () {
        Route::get('role-list', [UserRoleController::class, 'index']);
    });
    
    Route::middleware(['permission:view-role'])->group(function () {
        Route::get('role-permission/{id}', [UserRoleController::class, 'getRoleWisePermission']);
        Route::get('user-roles/{id}', [UserRoleController::class, 'userRoles']);
    });

    Route::middleware(['permission:view-permission-list'])->group(function () {
        Route::get('permission-list', [UserPermissionController::class, 'index']);
    });

    Route::middleware(['permission:view-permission'])->group(function () {
        Route::get('user-permissions/{id}', [UserPermissionController::class, 'getPermissionByUserId']);
    });

    Route::middleware(['permission:create-posts'])->group(function () {
        Route::post('create-post', [BlogPostController::class, 'store']);
    });

    Route::middleware(['permission:edit-posts'])->group(function () {
        Route::put('update-blog-post/{id}', [BlogPostController::class, 'update']);
    });

    Route::middleware(['permission:delete-posts'])->group(function () {
        Route::get('delete-post/{id}', [BlogPostController::class, 'destroy']);
    });

    Route::middleware(['permission:view-posts'])->group(function () {
        Route::get('all-posts', [BlogPostController::class, 'index']);
        Route::get('post/{id}', [BlogPostController::class, 'show']);
        Route::get('my-posts', [BlogPostController::class, 'userPosts']);
    });
});
