<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Permission;
use App\Models\Profile;
use App\Exceptions\{Profile\ProfileDeleteException, };
use App\Http\{Collections\ProfileCollection,
    Controllers\Controller,
    Requests\Profile\ProfileCreateRequest,
    Requests\Profile\ProfileUpdateRequest,
    Resources\ProfileResource,
    Responses\ApiErrorResponse,
    Responses\ApiSuccessResponse};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProfilesController extends Controller
{
    public function show(Profile $profile)
    {
        try {
            return new ApiSuccessResponse(
                data: new ProfileResource($profile),
                message: trans(key: 'messages.profiles.find_by_id_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function index(Request $request)
    {
        try {
            $profiles = Profile::filter($request->get(key: 'filters'))->with('permissions')->get();

            return new ApiSuccessResponse(
                data: ProfileCollection::make($profiles),
                message: trans(key: 'messages.profiles.list_all_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function store(ProfileCreateRequest $request)
    {
        try {
            $data = $request->validationData();
            $profile = Profile::create(attributes: $data);

            return new ApiSuccessResponse(
                data: new ProfileResource($profile),
                message: trans(key: 'messages.profiles.create_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function update(ProfileUpdateRequest $request, Profile $profile)
    {
        try {
            $data = $request->validationData();
            $data['updated_values'] = array_diff_assoc($profile->toArray(), $data);
            $profile->fill($data)->update();

            return new ApiSuccessResponse(
                data: new ProfileResource(Profile::find($profile->id)),
                message: trans(key: 'messages.profiles.update_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function destroy(Profile $profile)
    {
        try {
            if(!$profile->delete()) {
                throw new ProfileDeleteException();
            }

            return new ApiSuccessResponse(
                [],
                message: trans(key: 'messages.profiles.delete_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function getPermissions(Request $request, Profile $profile)
    {
        try {
            return new ApiSuccessResponse(
                data: ProfileCollection::make($profile->permissions()->get()->toArray()),
                message: 'Permissões do perfil listadas com sucesso!'
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function assignPermission(Request $request, Profile $profile, Permission $permission)
    {
        try {
            $profile->assignPermission($permission->name);
            return new ApiSuccessResponse(
                data: ProfileCollection::make($profile->permissions()->get()->toArray()),
                message: 'Permissão atribuída ao perfil com sucesso!'
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function revokePermission(Request $request, Profile $profile, Permission $permission)
    {
        try {
            $profile->revokePermission($permission->name);
            return new ApiSuccessResponse(
                data: ProfileCollection::make($profile->permissions()->get()->toArray()),
                message: 'Permissão revogada do perfil com sucesso!'
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }
}
