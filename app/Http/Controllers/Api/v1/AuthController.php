<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\{
    Controllers\Controller,
    Responses\ApiErrorResponse,
    Responses\ApiSuccessResponse,
};

/**
 * Controller responsável pelos end points de login e logout.
 */
class AuthController extends Controller
{

    /**
     * Action para end point /api/v1/login, para obter tokens de acesso
     *
     * @param Request $request
     * @return ApiErrorResponse|ApiSuccessResponse
     */
    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            return new ApiSuccessResponse(
                data: ['token' => $request->user()->createToken('invoice')],
                message: trans(key: 'app.logado_com_sucesso')
            );
        }
        return new ApiErrorResponse();
    }

    /**
     * Action para end point /api/v1/logout
     *
     * @param Request $request
     * @return ApiSuccessResponse
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return new ApiSuccessResponse(data: [], message: trans(key: 'app.logout_realizado_com_sucesso'));
    }
}
