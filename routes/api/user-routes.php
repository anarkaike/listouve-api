<?php

// Rotas para entidade usuário
use App\Http\Controllers\Api\v1\UsersController;
use Illuminate\Routing\Route;

Route::prefix('users')->group(function(){
    Route::get(uri: '', action: [UsersController::class, 'listAll']);
    Route::post(uri: '', action: [UsersController::class, 'create']);
    Route::get(uri: '/{id}', action: [UsersController::class, 'findById']);
    Route::put(uri: '/{id}', action: [UsersController::class, 'update']);
    Route::patch(uri: '/{id}', action: [UsersController::class, 'update']);
    Route::delete(uri: '/{id}', action: [UsersController::class, 'delete']);
})->middleware(['auth:sanctum']);
