<?php

namespace App\Http\Controllers\Api\v1;

use App\Exceptions\Auth\IncorrectCredentialsException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\{
    Controllers\Controller,
    Responses\ApiErrorResponse,
    Responses\ApiSuccessResponse,
};
use Laravel\Sanctum\PersonalAccessToken;

/**
 * Controller responsável pelos end points de login e logout.
 */
class AuthController extends Controller
{

    public function __construct()
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
     * @return ApiSuccessResponse|ApiErrorResponse
     */
    public function logout(Request $request)
    {
//        $request->session()->invalidate();
//        $request->session()->regenerateToken();

        // Get bearer token from the request
        $accessToken = $request->bearerToken();

        // Get access token from database
        $token = PersonalAccessToken::findToken($accessToken);

        // Revoke token
        if ($token->delete()) {
            return new ApiSuccessResponse(data: [], message: 'Deslogado com sucesso!');
        } else {
            return new ApiErrorResponse(new \Exception(message: 'Erro ao tentar deslogar.'), message: 'Erro ao tentar deslogar.');
        }
    }
}
