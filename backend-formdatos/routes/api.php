<?php

use App\Http\Controllers\Api\EmployeeFormController;
use Illuminate\Support\Facades\Route;

Route::get('/catalogs', [EmployeeFormController::class, 'catalogs']);
Route::post('/employee-forms/check-dni', [EmployeeFormController::class, 'checkDni']);
Route::post('/employee-forms', [EmployeeFormController::class, 'store']);
