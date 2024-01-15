<?php

namespace App\Http\Controllers\Api\v1;

use App\Actions\Bi\SaasClientBiAction;
use App\Actions\SaasClientAction;
use App\Models\SaasClient;
use App\Models\User;
use App\Notifications\SaasClientConfirmEmailNotification;
use App\Services\Upload;
use Illuminate\Support\Facades\DB;
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

            $file = $request->file('url_logo_up');
            if ($file) {
                $data['url_logo'] = Upload::uploadFile($file);
            }

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

            DB::beginTransaction();
            if( $saasClient = SaasClient::create(attributes: $data) ) {
                $saasClient->notify(new SaasClientConfirmEmailNotification(codeEmailValidation: $data['code_email_validation']));
            }

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => $data['password'],
            ]);
            $saasClient->users()->attach($user);


            DB::commit();
            return new ApiSuccessResponse(
                data: [
                    'token' => $user->createToken('invoice'),
                    'user' => $user->toArray(),
                    'saasClient' => new SaasClientResource($saasClient),
                ],
                message: trans(key: 'messages.saas_clients.create_success')
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function confirmEmail(Request $request)
    {
        try {
            $data = $request->all();
            if (!$saasClient = SaasClient::where('id', $data['id'])
                ->where('code_email_validation', $data['code'])
                ->whereNull('email_confirmed_at')
                ->first()) {
                throw new \Exception('Código invalido.');
            }
//            $saasClient->update(['email_confirmed_at' => now()]);

            $user = $saasClient->users()->first();

            return new ApiSuccessResponse(
                data: [
                    'token' => $user->createToken('invoice'),
                    'user' => $user->toArray(),
                    'saasClient' => new SaasClientResource($saasClient),
                ],
                message: 'Codigo validado com sucesso!'
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function update(SaasClientUpdateRequest $request, SaasClient $saasClient)
    {
        try {
            $data = $request->validationData();

            $file = $request->file('url_logo_up');
            if ($file) {
                $data['url_logo'] = Upload::uploadFile($file);
            }
            $file = $request->file('url_logo_up', null);
            if ($file) {
                $data['url_logo_up'] = Upload::uploadFile($file);
            }

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
