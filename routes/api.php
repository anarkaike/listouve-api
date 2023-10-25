<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\EventsController;
use App\Http\Controllers\Api\v1\EventsListsController;
use App\Http\Controllers\Api\v1\EventsListsItemsController;
use App\Http\Controllers\Api\v1\SaasClientsController;
use App\Http\Controllers\Api\v1\UsersController;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Route::post('/tokens/create', function (Request $request) {
//    $token = $request->user()->createToken($request->token_name);
//    return ['token' => $token->plainTextToken];
//});

Route::prefix('/v1')->group(function(){
    Route::post(uri: '/login', action: [AuthController::class, 'login']);
    Route::post(uri: '/logout', action: [AuthController::class, 'logout'])->middleware(['auth:sanctum']);

    Route::prefix('users')->group(function(){
        Route::get(uri: '', action: [UsersController::class, 'listAll']);
        Route::post(uri: '', action: [UsersController::class, 'create']);
        Route::get(uri: '/{id}', action: [UsersController::class, 'findById']);
        Route::put(uri: '/{id}', action: [UsersController::class, 'update']);
        Route::delete(uri: '/{id}', action: [UsersController::class, 'delete']);
    })->middleware(['auth:sanctum']);

    Route::prefix('events')->group(function(){
        Route::get(uri: '', action: [EventsController::class, 'listAll']);
        Route::post(uri: '', action: [EventsController::class, 'create']);
        Route::get(uri: '/{id}', action: [EventsController::class, 'findById']);
        Route::put(uri: '/{id}', action: [EventsController::class, 'update']);
        Route::delete(uri: '/{id}', action: [EventsController::class, 'delete']);
    })->middleware(['auth:sanctum']);

    Route::prefix('events-lists')->group(function(){
        Route::get(uri: '', action: [EventsListsController::class, 'listAll']);
        Route::post(uri: '', action: [EventsListsController::class, 'create']);
        Route::get(uri: '/{id}', action: [EventsListsController::class, 'findById']);
        Route::put(uri: '/{id}', action: [EventsListsController::class, 'update']);
        Route::delete(uri: '/{id}', action: [EventsListsController::class, 'delete']);
    })->middleware(['auth:sanctum']);

    Route::prefix('events-lists-items')->group(function(){
        Route::get(uri: '', action: [EventsListsItemsController::class, 'listAll']);
        Route::post(uri: '', action: [EventsListsItemsController::class, 'create']);
        Route::get(uri: '/{id}', action: [EventsListsItemsController::class, 'findById']);
        Route::put(uri: '/{id}', action: [EventsListsItemsController::class, 'update']);
        Route::delete(uri: '/{id}', action: [EventsListsItemsController::class, 'delete']);
    })->middleware(['auth:sanctum']);

    Route::prefix('saas-clients')->group(function(){
        Route::get(uri: '', action: [SaasClientsController::class, 'listAll']);
        Route::post(uri: '', action: [SaasClientsController::class, 'create']);
        Route::get(uri: '/{id}', action: [SaasClientsController::class, 'findById']);
        Route::put(uri: '/{id}', action: [SaasClientsController::class, 'update']);
        Route::delete(uri: '/{id}', action: [SaasClientsController::class, 'delete']);
    })->middleware(['auth:sanctum']);
});

//Route::post(uri: '/users', action: [UsersController::class, 'create']);
//Route::middleware(middleware: ['auth'])->group(function () {
//    Route::get(uri: '/users', action: [UsersController::class, 'listAll']);
//    Route::get(uri: '/users/{id}', action: [UsersController::class, 'findById']);
//    Route::put(uri: '/users/{id}', action: [UsersController::class, 'update']);
//    Route::delete(uri: '/users/{id}', action: [UsersController::class, 'delete']);
//});

//Route::prefix(prefix: '/v1')->group(callback: function () {
//Route::post(uri: '/login', action: [AuthController::class, 'login']);
