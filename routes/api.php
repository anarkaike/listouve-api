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
    Route::post(uri: '/saas-clients/auto-register', action: [SaasClientsController::class, 'autoRegister']);
    Route::post(uri: '/saas-clients/confirm-email', action: [SaasClientsController::class, 'confirmEmail']);
    Route::get(uri: '/saas-clients/by-current-domain', action: [SaasClientsController::class, 'getSaasClientByCurrentDomain']);


    Route::middleware('auth:sanctum')->group(function(){
        Route::post(uri: '/logout', action: [AuthController::class, 'logout']);

        // Clientes Saas
        Route::get(uri: '/saas-clients/bi', action: [SaasClientsController::class, 'bi']);
        Route::post(uri: '/saas-clients/{saasClient}', action: [SaasClientsController::class, 'update']);
        Route::apiResource(name: 'saas-clients', controller: SaasClientsController::class);

        // Perfis de Usuários
        Route::post(uri: '/profiles/{profile}', action: [ProfilesController::class, 'update']);
        Route::apiResource(name: 'profiles', controller: ProfilesController::class);
        Route::get(uri: '/profiles/{profile}/permissions', action: [ProfilesController::class, 'getPermissions']);
        Route::post(uri: '/profiles/{profile}/assignPermission/{permission}', action: [ProfilesController::class, 'assignPermission']);
        Route::post(uri: '/profiles/{profile}/revokePermission/{permission}', action: [ProfilesController::class, 'revokePermission']);

        // Permissões de Usuários
        Route::get(uri: '/permissions', action: [PermissionsController::class, 'index']);

        // Usuarios
        Route::get(uri: '/users/bi', action: [UsersController::class, 'bi']);
        Route::post(uri: '/users/{user}', action: [UsersController::class, 'update']);
        Route::apiResource(name: 'users', controller: UsersController::class);

        // Eventos
        Route::get(uri: '/events/bi', action: [EventsController::class, 'bi']);
        Route::post(uri: '/events/{event}', action: [EventsController::class, 'update']);
        Route::apiResource(name: 'events', controller: EventsController::class);

        // Listas de Convidados dos Eventos
        Route::get(uri: '/events-lists/bi', action: [EventsListsController::class, 'bi']);
        Route::post(uri: '/events-lists/{eventList}', action: [EventsListsController::class, 'update']);
        Route::apiResource(name: 'events-lists', controller: EventsListsController::class);

        // Convidados das Listas de Eventos
        Route::get(uri: '/events-lists-items/bi', action: [EventsListsItemsController::class, 'bi']);
        Route::post(uri: '/events-lists-items/{eventListItem}', action: [EventsListsItemsController::class, 'update']);
        Route::apiResource(name: 'events-lists-items', controller: EventsListsItemsController::class);


    });

});
