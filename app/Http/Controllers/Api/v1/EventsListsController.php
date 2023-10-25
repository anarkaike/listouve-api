<?php

namespace App\Http\Controllers\Api\v1;

use App\Contracts\Controllers\CrudEventListControllerInterface;
use App\Exceptions\EventList\EventListDeleteException;
use App\Exceptions\EventList\EventListNotFountException;
use Illuminate\Http\Request;
use App\Actions\EventListAction;
use App\Http\{Controllers\Controller,
    Requests\EventList\EventListCreateRequest,
    Requests\EventList\EventListDeleteRequest,
    Requests\EventList\EventListUpdateRequest,
    Responses\ApiErrorResponse,
    Responses\ApiSuccessResponse};

/**
 * Controllers para os end points relacionado a entidade usuário
 */
class EventsListsController extends Controller implements CrudEventListControllerInterface
{
    public function __construct(
        // Obtendo por injeção de dependencia o EventListAction e atribuindo ele como propriedade privada
        private EventListAction $eventListAction,
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
            $event = $this->eventListAction->findById(id: $request->route('id'));

            if (!$event) {
                throw new EventListNotFountException();
            }

            return new ApiSuccessResponse(
                data: $event->toArray(),
                message: 'Lista de evento obtida pelo ID com sucesso!'
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: 'Erro ao tentar buscar uma lista de evento pelo ID.',
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
            $event = $this->eventListAction->listAll();

            return new ApiSuccessResponse(
                data: $event->toArray(),
                message: 'Listas de eventos listadas com sucesso!'
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: 'Erro ao tentar listar listas de eventos.',
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
    public function create(EventListCreateRequest $request)
    {
        try {

            // Aqui eu chamo o Action
            // Action é a camada de negócio, chama repository, create log, send mail e etc.
            $event = $this->eventListAction->create(data: $request->validated());

            return new ApiSuccessResponse(
                data: $event->toArray(),
                message: 'Lista de evento criada com sucesso!'
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: 'Erro ao tentar criar uma lista de evento.',
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
    public function update(EventListUpdateRequest $request)
    {
        try {
            // Aqui eu chamo o Action
            // Action é a camada de negócio, chama repository, create log, send mail e etc.
            $event = $this->eventListAction->update(id: $request->route('id'), data: $request->validated());

            return new ApiSuccessResponse(
                data: $event->toArray(),
                message: 'Lista de evento atualizada com sucesso!'
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: 'Erro ao tentar atualizar uma lista de evento.',
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
    public function delete(EventListDeleteRequest $request)
    {
        try {
            // Aqui eu chamo o Action
            // Action é a camada de negócio, chama repository, create log, send mail e etc.
            if(!$this->eventListAction->delete(id: $request->route('id'))) {
                throw new EventListDeleteException();
            }

            return new ApiSuccessResponse(
                [],
                message: 'Lista de evento deletada com sucesso!'
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: 'Erro ao tentar deletar uma lista de evento.',
                data: [],
                request: $request
            );
        }
    }
}
