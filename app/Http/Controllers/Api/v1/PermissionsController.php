<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Permission;
use App\Models\Profile;
use App\Http\{Collections\PermissionCollection,
    Controllers\Controller,
    Responses\ApiErrorResponse,
    Responses\ApiSuccessResponse};
use Illuminate\Http\Request;


class PermissionsController extends Controller
{

    public function index(Request $request)
    {
        try {
            $permissions = Permission::get()->toArray();
            if ($profileId = $request->get('profile_id')) {
                foreach ($permissions as &$permission) {
                    $permission['allow'] = Permission::find($permission['id'])
                        ->profiles()
                        ->where('profile_id', $profileId)
                        ->exists();
                }
            }

            return new ApiSuccessResponse(
                data: $permissions,
                message: trans(key: 'messages.permissions.list_all_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

}
