<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Profile;
use App\Models\SaasClient;
use App\Models\User;
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
use Illuminate\Support\Facades\Auth;


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
            $users = User::filter($request->get(key: 'filters'))->with('profiles')->get();

            return new ApiSuccessResponse(
                data: UserCollection::make($users),
                message: trans(key: 'messages.users.list_all_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function store(UserCreateRequest $request)
    {
        try {
            $data = $request->validationData();
            $user = User::create(attributes: $data);

            $profiles = $request->get('profiles');
            $saasClients = $request->get('saas_client_id');
            foreach ($profiles as $profile) {
                foreach ($saasClients as $saasClient) {
                    $user->addProfile(Profile::find($profile['id'])->first(), $saasClient->id);
                }
            }

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
            $data['updated_values'] = Auth::id();
            $user->fill(attributes: $data)->update();

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
