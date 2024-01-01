<?php

namespace App\Http\Controllers\Api\v1;

use App\Actions\Bi\SaasClientBiAction;
use App\Actions\SaasClientAction;
use App\Models\SaasClient;
use App\Exceptions\{SaasClient\SaasClientDeleteException,};
use App\Http\{Collections\SaasClientCollection,
    Controllers\Controller,
    Requests\SaasClient\SaasClientCreateRequest,
    Requests\SaasClient\SaasClientDeleteRequest,
    Requests\SaasClient\SaasClientUpdateRequest,
    Resources\SaasClientResource,
    Responses\ApiErrorResponse,
    Responses\ApiSuccessResponse};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SaasClientsController extends Controller
{
    public function __construct(
        private SaasClientBiAction $saasClientBiAction,
    )
    {

    }

    public function show(SaasClient $saasClient)
    {
        try {
            return new ApiSuccessResponse(
                data: new SaasClientResource($saasClient),
                message: trans(key: 'messages.saas_clients.find_by_id_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function index()
    {
        try {
            $saasClients = SaasClient::get();

            return new ApiSuccessResponse(
                data: SaasClientCollection::make($saasClients),
                message: trans(key: 'messages.saas_clients.list_all_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function store(SaasClientCreateRequest $request)
    {
        try {
            $data = $request->validationData();
            $saasClient = SaasClient::create(attributes: $data);

            return new ApiSuccessResponse(
                data: new SaasClientResource($saasClient),
                message: trans(key: 'messages.saas_clients.create_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function update(SaasClientUpdateRequest $request, SaasClient $saasClient)
    {
        try {
            $data = $request->validationData();
            $data['updated_values'] = array_diff_assoc($saasClient->toArray(), $data);
            $saasClient->fill(attributes: $data)->update();

            return new ApiSuccessResponse(
                data: new SaasClientResource(SaasClient::find($saasClient->id)),
                message: trans(key: 'messages.saas_clients.update_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function destroy(SaasClient $saasClient)
    {
        try {
            if(!$saasClient->delete()) {
                throw new SaasClientDeleteException();
            }

            return new ApiSuccessResponse(
                [],
                message: trans(key: 'messages.saas_clients.delete_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function bi()
    {
        try {
            return new ApiSuccessResponse(
                $this->saasClientBiAction->all(),
                message: trans(key: 'messages.saas_clients.get_bi_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }
}
