<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Permission;
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
            $permissions = Permission::get();

            return new ApiSuccessResponse(
                data: PermissionCollection::make($permissions),
                message: trans(key: 'messages.permissions.list_all_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

}
