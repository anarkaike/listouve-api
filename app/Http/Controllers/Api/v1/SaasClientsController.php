<?php

namespace App\Http\Controllers\Api\v1;

use App\Actions\Bi\SaasClientBiAction;
use Illuminate\Http\Request;
use App\Contracts\Controllers\CrudSaasClientControllerInterface;
use App\Actions\SaasClientAction;
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
 * Controllers para os end points relacionado a entidade usuário
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
     * Action para end point de CRUD - GET /api/v1/events/{id}
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
                message: 'Cliente saas obtido pelo ID com sucesso!'
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: 'Erro ao tentar obter o cliente saas pelo ID.',
                data: [],
                request: $request
            );
        }
    }

    /**
     * Action para end point de CRUD - GET /api/v1/events
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
                message: 'Cliente saas listados com sucesso!'
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: 'Erro ao tentar listar clientes saas.',
                data: [],
                request: $request
            );
        }
    }

    /**
     * Action para end point CRUD - POST /api/v1/events
     *
     * @param Request $request
     * @return ApiErrorResponse|ApiSuccessResponse
     */
    public function create(SaasClientCreateRequest $request)
    {
        try {
            // Aqui eu chamo o Action
            // Action é a camada de negócio, chama repository, create log, send mail e etc.
            $event = $this->saasClientAction->create(data: $request->validated());

            return new ApiSuccessResponse(
                data: $event->toArray(),
                message: 'Cliente saas criado com sucesso!'
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: 'Erro ao tentar criar cliente saas.',
                data: [],
                request: $request
            );
        }
    }

    /**
     * Action para end point CRUD - PUT /api/v1/events/{id}
     *
     * @param Request $request
     * @return ApiErrorResponse|ApiSuccessResponse
     */
    public function update(SaasClientUpdateRequest $request)
    {
        try {
            // Aqui eu chamo o Action
            // Action é a camada de negócio, chama repository, create log, send mail e etc.
            $event = $this->saasClientAction->update(id: $request->route('id'), data: $request->validated());

            return new ApiSuccessResponse(
                data: $event->toArray(),
                message: 'Cliente saas atualizado com sucesso!'
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: 'Erro ao tentar atualizar cliente saas.',
                data: [],
                request: $request
            );
        }
    }

    /**
     * Action para end point CRUD - DELETE /api/v1/events/{id}
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
                message: 'Cliente saas deletado com sucesso!'
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: 'Erro ao tentar deletar cliente saas.',
                data: [],
                request: $request
            );
        }
    }

    /**
     * Action para end point que retorna dados do BI
     *
     * @param Request $request
     * @return ApiErrorResponse|ApiSuccessResponse
     */
    public function bi(Request $request)
    {
        try {
            return new ApiSuccessResponse(
                $this->saasClientBiAction->all(),
                message: 'Dados do BI obtidos com sucesso!'
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: 'Erro ao tentar obter os dados do BI.',
                data: [],
                request: $request
            );
        }
    }
}
