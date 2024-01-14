<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Profile;
use App\Models\SaasClient;
use App\Models\User;
use App\Services\Upload;
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
            $users = User::filter($request->get(key: 'filters'))->get();

            return new ApiSuccessResponse(
                data: UserCollection::make($users),
                message: trans(key: 'messages.users.list_all_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    private function addProfileAndSaasClient($request, $user) {
        $profilesIds = $request->get('profile_ids') ?? [];
        $saasClientsIds = $request->get('saas_client_ids') ?? [];
        if (count($profilesIds) > 0 && $saasClientsIds > 0) {
            foreach ($profilesIds as $profileId) {
                $profile = Profile::find($profileId);
                if ($profile) {
                    foreach ($saasClientsIds as $saasClientId) {
                        if (SaasClient::find($saasClientId)->exists()) {
                            $user->addProfile($profile->first(), $saasClientId);
                        }
                    }
                }
            }
        }
    }

    public function store(UserCreateRequest $request)
    {
        try {
            $data = $request->validationData();

            $file = $request->file('url_photo', null);
            if ($file) {
                $data['url_photo'] = Upload::uploadFile($file);
            }

            $user = User::create(attributes: $data);
            $this->addProfileAndSaasClient($request, $user);

            return new ApiSuccessResponse(
                data: new UserResource($user),
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

            $file = $request->file('url_photo', null);
            if ($file) {
                $data['url_photo'] = Upload::uploadFile($file);
            }

            $user->fill(attributes: $data)->update();
            $this->addProfileAndSaasClient($request, $user);

            return new ApiSuccessResponse(
                data: new UserResource(User::find($user->id)),
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
