<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Profile;
use App\Models\SaasClient;
use App\Models\User;
use App\Notifications\LinkAutoRegisterNotification;
use App\Actions\{
    Bi\UserBiAction,
};
use Illuminate\Http\Request;
use App\Exceptions\{
    User\UserDeleteException,
};
use App\Http\{
    Collections\UserCollection,
    Controllers\Controller,
    Requests\User\UserCreateRequest,
    Requests\User\UserUpdateRequest,
    Resources\UserResource,
    Responses\ApiErrorResponse,
    Responses\ApiSuccessResponse
};


class UsersController extends Controller
{
    public function __construct(
        private UserBiAction $userBiAction,
    )
    {

    }

    public function show(User $user)
    {
        try {
            return new ApiSuccessResponse(
                data: new UserResource($user),
                message: trans(key: 'messages.users.find_by_id_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function index(Request $request)
    {
        try {
            $builder = User::select('users.*')->join(table: 'saas_client_users', first: 'users.id', operator: '=', second: 'saas_client_users.user_id')
                ->where(column: 'saas_client_users.saas_client_id', operator: '=', value: $this->getSaasClientId());

            if (is_array($request->get(key: 'profile_ids'))) {
                $builder
                    ->join(table: 'user_profiles', first: 'user_profiles.user_id', operator: '=', second: 'users.id')
                    ->whereIn('user_profiles.profile_id', $request->get(key: 'profile_ids'));
            }
            $users = $builder->get();

            return new ApiSuccessResponse(
                data: UserCollection::make($users),
                message: trans(key: 'messages.users.list_all_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    private function updateProfilesOfUser($request, $user) {
        $currentProfiles = $user->profiles()->pluck('profiles.id')->toArray();
        $profilesIds = $request->get('profile_ids', []);
        $profilesIdsToRemove = array_diff($currentProfiles, $profilesIds);
        foreach ($profilesIdsToRemove as $profileId) {
            $profile = Profile::where('id', $profileId)->get()[0];
            if ($profile) {
                $user->removeProfile($profile, $saasClientsIds ?? null);
            }
        }
        foreach ($profilesIds as $profileId) {
            $profile = Profile::where('id', $profileId)->get()[0];
            if ($profile) {
                $user->addProfile($profile, $saasClientsIds ?? null);
            }
        }
    }

    private function updateSaasClientsOfUser($request, $user) {
        $saasClientsId = $request->get('saas_client_id', $this->getSaasClientId());
        if ($saasClientsId) {
            $user->addSaasClient(SaasClient::where('id', $saasClientsId)->get()[0]);
        }
//        $currentSaasClients = $user->saasClients()->pluck('saas_clients.id')->toArray();
//        $saasClientsToRemove = array_diff($currentSaasClients, [$saasClientsId]);
//        if (!$saasClientsId || count($saasClientsToRemove) > 0) {
//            foreach ($saasClientsToRemove as $saasClientId)
//                $user->removeSaasClient(SaasClient::where('id', $saasClientId)->get()[0]);
//        }
    }

    public function store(UserCreateRequest $request)
    {
        try {
            $data = $request->validationData();
            $data['url_photo'] = $this->upload(paramName: 'url_photo', request: $request);
            if (isset($data['auto_register']) && $data['auto_register']) {
                $data['token_auto_register'] = md5(date('YmdHis').rand(0,99999));
                $data['token_auto_register_at'] = date('Y-m-d H:i:s');
            }

            $user = User::create(attributes: $data);
            $this->updateSaasClientsOfUser($request, $user);
            $this->updateProfilesOfUser($request, $user);

            if (isset($data['auto_register']) && $data['auto_register']) {
                $user->notify(new LinkAutoRegisterNotification());
            }

            return new ApiSuccessResponse(
                data: new UserResource(User::where('id', $user->id)->get()[0]),
                message: trans(key: 'messages.users.create_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        try {
            $data = $request->validationData();
            $data['url_photo'] = $this->upload(paramName: 'url_photo', request: $request);

            $user->fill(attributes: $data)->update();
            $this->updateSaasClientsOfUser($request, $user);
            $this->updateProfilesOfUser($request, $user);

            return new ApiSuccessResponse(
                data: new UserResource(User::where('id', $user->id)->get()[0]),
                message: trans(key: 'messages.users.update_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function destroy(User $user)
    {
        try {
            if(!$user->delete()) {
                throw new UserDeleteException();
            }

            return new ApiSuccessResponse(
                [],
                message: trans(key: 'messages.users.delete_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function bi()
    {
        try {
            return new ApiSuccessResponse(
                $this->userBiAction->all(),
                message: trans(key: 'messages.users.get_bi_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }
}
