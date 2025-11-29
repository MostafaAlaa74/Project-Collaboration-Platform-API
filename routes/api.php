<?php

use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\Auth\logoutController;
use App\Http\Controllers\Auth\registerController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
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

Route::apiResource('projects', ProjectController::class)->middleware('auth:sanctum');
Route::post('/invite/{userId}', [InvitationController::class, 'invite'])->middleware('auth:sanctum');
Route::post('/invite/{userId}/accept', [InvitationController::class, 'accept'])->middleware('auth:sanctum')->name('invitations.accept');


Route::apiResource('tasks', TaskController::class)->middleware('auth:sanctum');
Route::get('/projects/{projectId}/tasks/priority/{priority}', [TaskController::class, 'getPriorityTasks'])->middleware('auth:sanctum');
Route::get('/projects/{projectId}/tasks/status/{status}', [TaskController::class, 'getStatusTasks'])->middleware('auth:sanctum');