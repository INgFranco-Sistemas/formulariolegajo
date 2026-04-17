<?php

use App\Http\Controllers\Api\AdminAuthController;
use App\Http\Controllers\Api\AdminEmployeeFormController;
use App\Http\Controllers\Api\EmployeeFormController;
use Illuminate\Support\Facades\Route;

Route::get('/catalogs', [EmployeeFormController::class, 'catalogs']);
Route::post('/employee-forms/check-dni', [EmployeeFormController::class, 'checkDni']);
Route::post('/employee-forms', [EmployeeFormController::class, 'store']);

Route::prefix('admin')->group(function () {
    Route::post('/login', [AdminAuthController::class, 'login']);

    Route::middleware('auth:admin_api')->group(function () {
        Route::get('/me', [AdminAuthController::class, 'me']);
        Route::post('/logout', [AdminAuthController::class, 'logout']);
        Route::get('/employee-forms', [AdminEmployeeFormController::class, 'index']);
        Route::get('/employee-forms/{id}', [AdminEmployeeFormController::class, 'show']);
        Route::put('/employee-forms/{id}', [AdminEmployeeFormController::class, 'update']);
    });
});