<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\WorkShiftController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('user', [AuthController::class, 'signup']);

Route::group(['middleware' => ['ApiAuth', 'AuthAdmin']], function () {
    Route::get('user', [AuthController::class, 'UsersList']);

    Route::post('work-shift', [WorkShiftController::class, 'createShift']);
    Route::get('work-shift/{id}/open', [WorkShiftController::class, 'openShift']);
    Route::get('work-shift/{id}/close', [WorkShiftController::class, 'closeShift']);
    Route::post('work-shift/{id}/user', [WorkShiftController::class, 'addUser']);

});

Route::post('order', [OrdersController::class, 'createOrder']);

