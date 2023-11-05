<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Actions\EventAction;
use App\Contracts\Controllers\CrudEventControllerInterface;
use App\Http\{
    Controllers\Controller,
    Requests\Event\EventCreateRequest,
    Requests\Event\EventDeleteRequest,
    Requests\Event\EventUpdateRequest,
    Responses\ApiErrorResponse,
    Responses\ApiSuccessResponse
};
use App\Exceptions\{
    Event\EventNotFountException,
    Event\EventDeleteException,
};
use App\Actions\Bi\EventBiAction;

/**
 * Controllers para os end points relacionado a entidade usuário
 */
class EventsController extends Controller implements CrudEventControllerInterface
{
    public function __construct(
        // Obtendo por injeção de dependencia o EventAction e atribuindo ele como propriedade privada
        private EventAction $eventAction,
        private EventBiAction $eventBiAction,
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
            $event = $this->eventAction->findById(id: $request->route('id'));

            if (!$event) {
                throw new EventNotFountException();
            }

            return new ApiSuccessResponse(
                data: $event->toArray(),
                message: 'Evento obtido pelo ID com sucesso!'
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: 'Erro ao tentar buscar um evento pelo ID.',
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
            $event = $this->eventAction->listAll();

            return new ApiSuccessResponse(
                data: $event->toArray(),
                message: 'Eventos listados com sucesso!'
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: 'Erro ao tentar listar os eventos.',
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
    public function create(EventCreateRequest $request)
    {
        try {
            // Aqui eu chamo o Action
            // Action é a camada de negócio, chama repository, create log, send mail e etc.
            $event = $this->eventAction->create(data: $request->validated());

            return new ApiSuccessResponse(
                data: $event->toArray(),
                message: 'Evento criado com sucesso!'
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: 'Erro ao tentar criar um evento.',
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
    public function update(EventUpdateRequest $request)
    {
        try {
            // Aqui eu chamo o Action
            // Action é a camada de negócio, chama repository, create log, send mail e etc.
            $event = $this->eventAction->update(id: $request->route('id'), data: $request->validated());

            return new ApiSuccessResponse(
                data: $event->toArray(),
                message: 'Evento atualizado com sucesso!'
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: 'Erro ao tentar atualizar um evento.',
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
    public function delete(EventDeleteRequest $request)
    {
        try {
            // Aqui eu chamo o Action
            // Action é a camada de negócio, chama repository, create log, send mail e etc.
            if(!$this->eventAction->delete(id: $request->route('id'))) {
                throw new EventDeleteException();
            }

            return new ApiSuccessResponse(
                [],
                message: 'Evento deletado com sucesso!'
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: 'Erro ao tentar deletar um evento.',
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
                $this->eventBiAction->all(),
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
