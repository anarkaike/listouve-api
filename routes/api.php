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


    Route::middleware('auth:sanctum')->group(function(){
        Route::post(uri: '/logout', action: [AuthController::class, 'logout']);


        // Info para BI
        Route::get(uri: '/users/bi', action: [UsersController::class, 'bi']);
        Route::get(uri: '/events/bi', action: [EventsController::class, 'bi']);
        Route::get(uri: '/events-lists/bi', action: [EventsController::class, 'bi']);
        Route::get(uri: '/events-lists-items/bi', action: [EventsController::class, 'bi']);
        Route::get(uri: '/saas-clients/bi', action: [EventsController::class, 'bi']);

        // Api CRUDs
        Route::apiResource(name: 'users', controller: UsersController::class);
        Route::apiResource(name: 'events', controller: EventsController::class);
        Route::apiResource(name: 'events-lists', controller: EventsListsController::class);
        Route::apiResource(name: 'events-lists-items', controller: EventsListsItemsController::class);
        Route::apiResource(name: 'saas-clients', controller: SaasClientsController::class);

    });

});
