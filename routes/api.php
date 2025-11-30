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

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('projects', ProjectController::class);
    Route::post('/invite/{userId}/project/{projectId}', [InvitationController::class, 'invite']);
    Route::post('/invite/{projectId}/accept', [InvitationController::class, 'accept'])->name('invitations.accept');
    Route::post('/projects/{projectId}/members/{userId}/role', [ProjectController::class, 'changeMemberRole']);

    Route::apiResource('tasks', TaskController::class);
    Route::get('project/{projectId}/tasks', [TaskController::class, 'getProjectTasks']);
    Route::get('/projects/{projectId}/tasks/priority/{priority}', [TaskController::class, 'getPriorityTasks']);
    Route::get('/projects/{projectId}/tasks/status/{status}', [TaskController::class, 'getStatusTasks']);
});
