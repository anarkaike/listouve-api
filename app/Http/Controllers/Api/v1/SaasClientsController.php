<?php

namespace App\Http\Controllers\Api\v1;

use App\Actions\Bi\SaasClientBiAction;
use Illuminate\Http\Request;
use App\Contracts\Controllers\CrudSaasClientControllerInterface;
use App\Actions\SaasClientAction;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\{
    SaasClient\SaasClientDeleteException,
    SaasClient\SaasClientNotFountException,
};
use App\Http\{
    Controllers\Controller,
    Requests\SaasClient\SaasClientCreateRequest,
    Requests\SaasClient\SaasClientDeleteRequest,
    Requests\SaasClient\SaasClientUpdateRequest,
    Responses\ApiErrorResponse,
    Responses\ApiSuccessResponse,
};

/**
 * Controllers para os en points relacionado a entidade usuário
 */
class SaasClientsController extends Controller implements CrudSaasClientControllerInterface
{
    public function __construct(
        // Obtendo por injeção de dependencia o SaasClientAction e atribuindo ele como propriedade privada
        private SaasClientAction $saasClientAction,
        private SaasClientBiAction $saasClientBiAction,
    )
    {

    }

    /**
     * Action para en point de CRUD - GET /api/v1/events/{id}
     *
     * @param Request $request
     * @return ApiErrorResponse|ApiSuccessResponse
     */
    public function findById(Request $request)
    {
        try {
            // Aqui eu chamo o Action
            // Action é a camada de negócio, chama repository, create log, send mail e etc.
            $event = $this->saasClientAction->findById(id: $request->route('id'));

            if (!$event) {
                throw new SaasClientNotFountException();
            }

            return new ApiSuccessResponse(
                data: $event->toArray(),
                message: trans(key: 'messages.saas_clients.find_by_id_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    /**
     * Action para en point de CRUD - GET /api/v1/events
     *
     * @param Request $request
     * @return ApiErrorResponse|ApiSuccessResponse
     */
    public function listAll(Request $request)
    {
        try {
            // Aqui eu chamo o Action
            // Action é a camada de negócio, chama repository, create log, send mail e etc.
            $event = $this->saasClientAction->listAll();

            return new ApiSuccessResponse(
                data: $event->toArray(),
                message: trans(key: 'messages.saas_clients.list_all_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    /**
     * Action para en point CRUD - POST /api/v1/events
     *
     * @param Request $request
     * @return ApiErrorResponse|ApiSuccessResponse
     */
    public function create(SaasClientCreateRequest $request)
    {
        try {
            // Aqui eu chamo o Action
            // Action é a camada de negócio, chama repository, create log, send mail e etc.
            $data = $request->validationData();
            $data['created_by'] = Auth::id();
            $event = $this->saasClientAction->create(data: $data);

            return new ApiSuccessResponse(
                data: $event->toArray(),
                message: trans(key: 'messages.saas_clients.create_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    /**
     * Action para en point CRUD - PUT /api/v1/events/{id}
     *
     * @param Request $request
     * @return ApiErrorResponse|ApiSuccessResponse
     */
    public function update(SaasClientUpdateRequest $request)
    {
        try {
            // Aqui eu chamo o Action
            // Action é a camada de negócio, chama repository, create log, send mail e etc.
            $data = $request->validationData();
            $data['updated_by'] = Auth::id();
            $event = $this->saasClientAction->update(id: $request->route('id'), data: $data);

            return new ApiSuccessResponse(
                data: $event->toArray(),
                message: trans(key: 'messages.saas_clients.update_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    /**
     * Action para en point CRUD - DELETE /api/v1/events/{id}
     *
     * @param Request $request
     * @return ApiErrorResponse|ApiSuccessResponse
     */
    public function delete(SaasClientDeleteRequest $request)
    {
        try {
            // Aqui eu chamo o Action
            // Action é a camada de negócio, chama repository, create log, send mail e etc.
            if(!$this->saasClientAction->delete(id: $request->route('id'))) {
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

    /**
     * Action para en point que retorna dados do BI
     *
     * @param Request $request
     * @return ApiErrorResponse|ApiSuccessResponse
     */
    public function bi(Request $request)
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
