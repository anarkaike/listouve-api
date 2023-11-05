<?php

namespace App\Http\Controllers\Api\v1;

use App\Actions\UserAction;
use App\Exceptions\Auth\IncorrectCredentialsException;
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

    public function __construct(
        private UserAction $userAction
    )
    {

    }

    /**
     * Action para end point /api/v1/login, para obter tokens de acessoo
     *
     * @param Request $request
     * @return ApiErrorResponse|ApiSuccessResponse
     */
    public function login(Request $request)
    {
        try {
            if (!Auth::attempt($request->only('email', 'password'))) {
                throw new IncorrectCredentialsException();
            }

            return new ApiSuccessResponse(
                data: [
                    'token' => $request->user()->createToken('invoice'),
                    'user' => $request->user()->toArray()
                ],
                message: trans(key: 'app.logado_com_sucesso')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: $e->getMessage(),
                data: [],
                request: $request
            );
        }
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
