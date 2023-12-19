<?php

namespace App\Http\Controllers\Api\v1;

use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\{
    Http\Request,
    Support\Facades\Auth,
};
use App\Exceptions\Auth\{
    InvalidTokenException,
    LogoutException,
    IncorrectCredentialsException,
};
use App\Http\{
    Controllers\Controller,
    Responses\ApiErrorResponse,
    Responses\ApiSuccessResponse,
};


class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            if (!Auth::attempt($request->only('email', 'password'))) {
                throw new IncorrectCredentialsException();
            }

            $data = [
                'token' => $request->user()->createToken('invoice', [
                    //Users Abilities
                    'users:listAll',
                    'users:findById',
//                    'users:create',
                    'users:update',
                    'users:delete',
                    'users:bi',

                    //Saas Clients Abilities
                    'saasClients:listAll',
                    'saasClients:findById',
                    'saasClients:create',
                    'saasClients:update',
                    'saasClients:delete',
                    'saasClients:bi',

                    //Events Abilities
                    'events:listAll',
                    'events:findById',
                    'events:create',
                    'events:update',
                    'events:delete',
                    'events:bi',

                    //Events Lists Abilities
                    'eventsLists:listAll',
                    'eventsLists:findById',
                    'eventsLists:create',
                    'eventsLists:update',
                    'eventsLists:delete',
                    'eventsLists:bi',

                    //Events Lists Abilities
                    'eventsListsItems:listAll',
                    'eventsListsItems:findById',
                    'eventsListsItems:create',
                    'eventsListsItems:update',
                    'eventsListsItems:delete',
                    'eventsListsItems:bi',
                ]),
                'user' => $request->user()->toArray()
            ];
            return new ApiSuccessResponse(data: $data, message: trans(key: 'auth.user_authenticated_successfully'));

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function logout(Request $request)
    {
        try {
            $accessToken = $request->bearerToken();
            $token = PersonalAccessToken::findToken($accessToken);

            if (!$token)            throw new InvalidTokenException();
            if (!$token->delete())  throw new LogoutException();

            return new ApiSuccessResponse(data: [], message: trans(key: 'auth.logged_out_user_with_success'));

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }
}
