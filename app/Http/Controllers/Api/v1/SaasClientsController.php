<?php

namespace App\Http\Controllers\Api\v1;

use App\Actions\Bi\SaasClientBiAction;
use App\Actions\SaasClientAction;
use App\Models\Profile;
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
            $data['url_logo'] = $this->upload(paramName: 'url_logo', request: $request);
            $data['url_login_bg'] = $this->upload(paramName: 'url_login_bg', request: $request);
            $data['url_system_bg'] = $this->upload(paramName: 'url_system_bg', request: $request);

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
            if( !$saasClient = SaasClient::create(attributes: $data) ) {
                throw new \Exception('Erro ao realizar o cadastro');
            }

            $user = User::create([
                'name' => $data['contact_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => $data['password'],
            ]);

            DB::commit();
            $saasClient->users()->attach($user);

            $arrBusinessSectorToProfile = [
                'bar' => 3, // dono de estabelecimento
                'boate' => 3, // dono de estabelecimento
                'produtor_de_festas' => 4, // cerimonialista
                'cerimonialista' => 5, // cerimonialista
                'outros' => 3, // dono de estabelecimento
            ];
            if (isset($data['business_sector']) && isset($arrBusinessSectorToProfile[$data['business_sector']])) {
                $profileId = $arrBusinessSectorToProfile[$data['business_sector']];
                $user->addProfile(Profile::find($profileId), $saasClient->id);
            }

            $saasClient->notify(new SaasClientConfirmEmailNotification(codeEmailValidation: $data['code_email_validation']));
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
            $data['url_logo'] = $this->upload(paramName: 'url_logo', request: $request);
            $data['url_login_bg'] = $this->upload(paramName: 'url_login_bg', request: $request);
            $data['url_system_bg'] = $this->upload(paramName: 'url_system_bg', request: $request);

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

    public function getSaasClientByCurrentDomain()
    {
        $saasClient = SaasClient::where('domain_front', \App\Helpers\SaasClient::getDomainAccessByHaeder())->get()->first();

        // Atenção. Esse end ponit não precisa estar logado.
        // Escolhendo informações que vai ir para o front, para não ir dados sensiveis.
        $saasClientResponse = [];
        if ($saasClient) {
            $saasClientResponse['business_sector'] = $saasClient->business_sector;
            $saasClientResponse['company_name'] = $saasClient->company_name;
            $saasClientResponse['email'] = $saasClient->email;
            $saasClientResponse['phone'] = $saasClient->phone;
            $saasClientResponse['status'] = $saasClient->status;
            $saasClientResponse['url_logo'] = $saasClient->url_logo;
        }

        try {
            return new ApiSuccessResponse(
                $saasClientResponse,
                message: 'Dados do cliente saas recuperados com sucesso'
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }
}
