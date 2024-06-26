<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Users\UserAuthController;
use App\Http\Controllers\Api\Tasks\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'api','as' => 'api.'], function () {
    Route::group(['prefix' => 'user','as' => 'user.'], function () {
        Route::post('/login', [UserAuthController::class, 'login'])->name('login');
        Route::post('/signup', [UserAuthController::class, 'signup'])->name('signup');
        Route::group(['middleware' => 'auth:sanctum'], function() {
            Route::get('logout', [UserAuthController::class, 'logout'])->name('logout');
        });
    });

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::resource('task', TaskController::class)->only(['index','store']);
    });
});