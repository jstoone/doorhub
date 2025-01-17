<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyUserController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/token', [TokenController::class, 'store']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('companies', CompanyController::class)
        ->only(['index', 'store', 'show']);
    Route::apiResource('companies.users', CompanyUserController::class)
        ->only(['index', 'store', 'show']);
    Route::apiResource('users', UserController::class)
        ->only(['index', 'store', 'show']);
});
