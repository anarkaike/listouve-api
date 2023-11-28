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


/**
 * Controller responsável pelos en points de login e logout.
 */
class AuthController extends Controller
{
    /**
     * Obter token - Action para en point /api/v1/login, para obter tokens de acessoo
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

            $data = [
                'token' => $request->user()->createToken('invoice'),
                'user' => $request->user()->toArray()
            ];
            return new ApiSuccessResponse(data: $data, message: trans(key: 'auth.user_authenticated_successfully'));

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    /**
     * Deslogar token - Action para en point /api/v1/logout
     *
     * @param Request $request
     * @return ApiSuccessResponse|ApiErrorResponse
     */
    public function logout(Request $request)
    {
        try {
            // $request->session()->invalidate();
            // $request->session()->regenerateToken();
            // Obtendo o token enviado na requisição
            $accessToken = $request->bearerToken();

            // Buscando token na base de dados
            $token = PersonalAccessToken::findToken($accessToken);

            if (!$token)            throw new InvalidTokenException();
            if (!$token->delete())  throw new LogoutException();

            return new ApiSuccessResponse(data: [], message: trans(key: 'auth.logged_out_user_with_success'));

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }
}
