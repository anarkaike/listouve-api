<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use App\Actions\{
    Bi\UserBiAction,
    UserAction,
};
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
        private UserAction $userAction,
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

    public function index()
    {
        try {
            $users = $this->userAction->listAll();

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
            $user = $this->userAction->create(data: $data);

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
            $user = $this->userAction->update(id: $user->id, data: $user->fill($data)->toArray());

            return new ApiSuccessResponse(
                data: new UserResource($user),
                message: trans(key: 'messages.users.update_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function destroy(User $user)
    {
        try {
            if(!$this->userAction->delete(id: $user->id)) {
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
