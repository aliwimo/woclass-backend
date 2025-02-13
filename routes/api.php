<?php

use App\Http\Controllers\api\v1\ClassroomController;
use App\Http\Controllers\api\v1\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/v1')->group(function () {

    /** Classrooms Routes */
    Route::prefix('/classrooms')->group(callback: function () {
        Route::get('/', [ClassroomController::class, 'index']);
        Route::get('{id}/sessions', [ClassroomController::class, 'getSessions']);

    });

    /** Events Routes */
    Route::prefix('/events')->group(callback: function () {
        Route::get('/', [EventController::class, 'index']);
        Route::post('/', [EventController::class, 'store']);
    });
});

