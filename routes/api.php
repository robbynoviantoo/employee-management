<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EmployeeController;

// Rute untuk login dan menghasilkan token
Route::post('/login', [AuthController::class, 'login']);

// Rute untuk menghasilkan token secara manual
Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
})->middleware('auth:sanctum');

// Grup rute yang dilindungi dengan middleware auth:sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('/employees', EmployeeController::class);
});