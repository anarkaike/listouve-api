<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\{
    AuthController,
    EventsController,
    EventsListsController,
    EventsListsItemsController,
    SaasClientsController,
    UsersController,
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('/v1')->group(function(){
    Route::post(uri: '/login', action: [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post(uri: '/logout', action: [AuthController::class, 'logout']);


    // Rotas para entidade usuário
    Route::middleware('auth:sanctum')->prefix('users')->group(function(){
        Route::get(uri: '/bi', action: [UsersController::class, 'bi']);
        Route::get(uri: '', action: [UsersController::class, 'listAll']);
        Route::post(uri: '', action: [UsersController::class, 'create']);
        Route::get(uri: '/{id}', action: [UsersController::class, 'findById']);
        Route::put(uri: '/{id}', action: [UsersController::class, 'update']);
        Route::patch(uri: '/{id}', action: [UsersController::class, 'update']);
        Route::delete(uri: '/{id}', action: [UsersController::class, 'delete']);
    });

    // Rotas para entidade eventos
    Route::middleware('auth:sanctum')->prefix('events')->group(function(){
        Route::get(uri: '/bi', action: [EventsController::class, 'bi']);
        Route::get(uri: '', action: [EventsController::class, 'listAll']);
        Route::post(uri: '', action: [EventsController::class, 'create']);
        Route::get(uri: '/{id}', action: [EventsController::class, 'findById']);
        Route::put(uri: '/{id}', action: [EventsController::class, 'update']);
        Route::patch(uri: '/{id}', action: [EventsController::class, 'update']);
        Route::delete(uri: '/{id}', action: [EventsController::class, 'delete']);
    });

    // Rotas para entidade lista de eventos
    Route::middleware('auth:sanctum')->prefix('events-lists')->group(function(){
        Route::get(uri: '/bi', action: [EventsListsController::class, 'bi']);
        Route::get(uri: '', action: [EventsListsController::class, 'listAll']);
        Route::post(uri: '', action: [EventsListsController::class, 'create']);
        Route::get(uri: '/{id}', action: [EventsListsController::class, 'findById']);
        Route::put(uri: '/{id}', action: [EventsListsController::class, 'update']);
        Route::patch(uri: '/{id}', action: [EventsListsController::class, 'update']);
        Route::delete(uri: '/{id}', action: [EventsListsController::class, 'delete']);
    });

    // Rotas para entidade itens/nomes da lista de eventos
    Route::middleware('auth:sanctum')->prefix('events-lists-items')->group(function(){
        Route::get(uri: '/bi', action: [EventsListsItemsController::class, 'bi']);
        Route::get(uri: '', action: [EventsListsItemsController::class, 'listAll']);
        Route::post(uri: '', action: [EventsListsItemsController::class, 'create']);
        Route::get(uri: '/{id}', action: [EventsListsItemsController::class, 'findById']);
        Route::put(uri: '/{id}', action: [EventsListsItemsController::class, 'update']);
        Route::patch(uri: '/{id}', action: [EventsListsItemsController::class, 'update']);
        Route::delete(uri: '/{id}', action: [EventsListsItemsController::class, 'delete']);
    });

    // Rotas para entidade clientes do saas
    Route::middleware('auth:sanctum')->prefix('saas-clients')->group(function(){
        Route::get(uri: '/bi', action: [SaasClientsController::class, 'bi']);
        Route::get(uri: '', action: [SaasClientsController::class, 'listAll']);
        Route::post(uri: '', action: [SaasClientsController::class, 'create']);
        Route::get(uri: '/{id}', action: [SaasClientsController::class, 'findById']);
        Route::put(uri: '/{id}', action: [SaasClientsController::class, 'update']);
        Route::patch(uri: '/{id}', action: [SaasClientsController::class, 'update']);
        Route::delete(uri: '/{id}', action: [SaasClientsController::class, 'delete']);
    });

});
