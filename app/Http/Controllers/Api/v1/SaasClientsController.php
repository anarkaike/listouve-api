<?php

namespace App\Http\Controllers\Api\v1;

use App\Actions\Bi\SaasClientBiAction;
use App\Actions\SaasClientAction;
use App\Models\SaasClient;
use App\Models\User;
use App\Notifications\SaasClientConfirmEmailNotification;
use App\Exceptions\{SaasClient\SaasClientDeleteException, SaasClient\SaasClientNotFountException};
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

    public function autoRegister(SaasClientCreateRequest $request)
    {
        try {
            $data = $request->validationData();
            $data['code_email_validation'] = substr(strtoupper(md5(date('YmdHis') . rand(0,9999))), 0, 5);
            if( $saasClient = SaasClient::create(attributes: $data) ) {
                $saasClient->notify(new SaasClientConfirmEmailNotification(codeEmailValidation: $data['code_email_validation']));
            }

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => $data['password'],
            ]);

            return new ApiSuccessResponse(
                data: [
                    'token' => $user->createToken('invoice'),
                    'user' => $user->toArray(),
                    'saasClient' => new SaasClientResource($saasClient),
                ],
                message: trans(key: 'messages.saas_clients.create_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function confirmEmail(Request $request)
    {
        try {
            $data = $request->all();
            if (!SaasClient::where('id', $data['id'])->where('code_email_validation', $data['code'])->exists()) {
                throw new \Exception('Código invalido.');
            }

            return new ApiSuccessResponse(
                data: [],
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
