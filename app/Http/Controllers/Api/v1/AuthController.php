<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Profile;
use App\Models\SaasClient;
use App\Notifications\NewSaasClientForAdminNotification;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\{Http\Request, Support\Arr, Support\Facades\Auth};
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

            Auth::user()->notify(new NewSaasClientForAdminNotification(SaasClient::factory()->create(['email'=>'anarkaike+emailtestejunio@gmail.com'])));

            // Buscando permissões relacionado ao usuário e aos perfis relacionados ao usuário
            $profilesIdsOfUser = array_column(array: $request->user()->profiles()->get()->toArray(), column_key: 'id');
            $permissionsOfProfilesOfUser = [];
            foreach ($profilesIdsOfUser as $profileId) {
                $permissionsOfProfilesOfUser[] = Arr::pluck(array: Profile::find($profileId)->permissions()->get()->toArray(), value: 'name');
            }
            $permissionsOfUser = Arr::pluck($request->user()->permissions()->get()->toArray(), 'name');

            $permissions = array_unique(array_merge($permissionsOfUser, $permissionsOfProfilesOfUser));
            $data = [
                'token' => $request->user()->createToken('invoice', $permissions),
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
