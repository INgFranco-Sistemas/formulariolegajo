<?php

use App\Http\Controllers\Api\AdminAuthController;
use App\Http\Controllers\Api\AdminEmployeeFormController;
use App\Http\Controllers\Api\EmployeeFormController;
use App\Http\Controllers\Api\AdminLegajoController;
use App\Http\Controllers\Api\AdminLegajoDocumentController;
use App\Http\Controllers\Api\AdminLegajoPdfController;
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
        Route::get('/employee-forms-export', [AdminEmployeeFormController::class, 'exportExcel']);

        Route::get('/legajos', [AdminLegajoController::class, 'index']);
        Route::post('/legajos', [AdminLegajoController::class, 'store']);
        Route::get('/legajos/{id}', [AdminLegajoController::class, 'show']);

        Route::get('/legajos/{legajoId}/documents', [AdminLegajoDocumentController::class, 'index']);
        Route::post('/legajos/{legajoId}/documents', [AdminLegajoDocumentController::class, 'store']);
        Route::delete('/legajos/{legajoId}/documents/{documentId}', [AdminLegajoDocumentController::class, 'destroy']);

        Route::get('/legajos/{id}/ficha-pdf', [AdminLegajoPdfController::class, 'fichaDatosGenerales']);
    });
});