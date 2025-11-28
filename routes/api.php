<?php

use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\Auth\logoutController;
use App\Http\Controllers\Auth\registerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [registerController::class, 'register']);
    Route::post('/login', [loginController::class, 'login']);
    Route::post('/logout', [logoutController::class, 'logout'])->middleware('auth:sanctum');
});
