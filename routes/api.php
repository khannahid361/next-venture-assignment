<?php

use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Http\Controllers\AuthorizationController;
use Laravel\Passport\Http\Controllers\TransientTokenController;
use App\Http\Controllers\API\RegisterController;
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

Route::middleware('auth:api')->get('user', function (Request $request) {
    return $request->user();
});
