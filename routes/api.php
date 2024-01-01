<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\{AuthController,
    EventsController,
    EventsListsController,
    EventsListsItemsController,
    PermissionsController,
    ProfilesController,
    SaasClientsController,
    UsersController};

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

        // Clientes Saas
        Route::apiResource(name: 'saas-clients', controller: SaasClientsController::class);
        Route::get(uri: '/saas-clients/bi', action: [EventsController::class, 'bi']);

        // Perfis de Usuários
        Route::apiResource(name: 'profiles', controller: ProfilesController::class);
        Route::get(uri: '/profiles/{profile}/permissions', action: [ProfilesController::class, 'getPermissions']);
        Route::post(uri: '/profiles/{profile}/assignPermission/{permission}', action: [ProfilesController::class, 'assignPermission']);
        Route::post(uri: '/profiles/{profile}/revokePermission/{permission}', action: [ProfilesController::class, 'revokePermission']);

        // Permissões de Usuários
        Route::get(uri: '/permissions', action: [PermissionsController::class, 'index']);
        Route::apiResource(name: 'users', controller: UsersController::class);
        Route::get(uri: '/users/bi', action: [UsersController::class, 'bi']);

        // Eventos
        Route::apiResource(name: 'events', controller: EventsController::class);
        Route::get(uri: '/events/bi', action: [EventsController::class, 'bi']);

        // Listas de Convidados dos Eventos
        Route::apiResource(name: 'events-lists', controller: EventsListsController::class);
        Route::get(uri: '/events-lists/bi', action: [EventsController::class, 'bi']);

        // Convidados das Listas de Eventos
        Route::apiResource(name: 'events-lists-items', controller: EventsListsItemsController::class);
        Route::get(uri: '/events-lists-items/bi', action: [EventsController::class, 'bi']);


    });

});
