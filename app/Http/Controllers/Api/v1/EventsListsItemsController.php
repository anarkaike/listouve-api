<?php

namespace App\Http\Controllers\Api\v1;

use App\Actions\Bi\EventListItemBiAction;
use Illuminate\Http\Request;
use App\Contracts\Controllers\CrudEventListItemControllerInterface;
use App\Actions\EventListItemAction;
use App\Exceptions\{
    EventListItem\EventListItemDeleteException,
    EventListItem\EventListItemNotFountException,
};
use App\Http\{
    Controllers\Controller,
    Requests\EventListItem\EventListItemCreateRequest,
    Requests\EventListItem\EventListItemDeleteRequest,
    Requests\EventListItem\EventListItemUpdateRequest,
    Responses\ApiErrorResponse,
    Responses\ApiSuccessResponse,
};
use Illuminate\Support\Facades\Auth;

/**
 * Controllers para os end points relacionado a entidade usuário
 */
class EventsListsItemsController extends Controller implements CrudEventListItemControllerInterface
{
    public function __construct(
        // Obtendo por injeção de dependencia o EventListItemAction e atribuindo ele como propriedade privada
        private EventListItemAction   $eventListItemAction,
        private EventListItemBiAction $eventListItemBiAction,
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
            $event = $this->eventListItemAction->findById(id: $request->route('id'));

            if (!$event) {
                throw new EventListItemNotFountException();
            }

            return new ApiSuccessResponse(
                data: $event->toArray(),
                message: 'Nome na lista de evento obtida pelo ID com sucesso!'
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: 'Erro ao tentar buscar um nome na lista de evento pelo ID.',
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
            $event = $this->eventListItemAction->listAll();

            return new ApiSuccessResponse(
                data: $event->toArray(),
                message: 'Listas de eventos listadas com sucesso!'
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: 'Erro ao tentar listar nomes da lista de eventos.',
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
    public function create(EventListItemCreateRequest $request)
    {
        try {
            // Aqui eu chamo o Action
            // Action é a camada de negócio, chama repository, create log, send mail e etc.
            $data = $request->validationData();
            $data['created_by'] = Auth::id();
            $event = $this->eventListItemAction->create(data: $data);

            return new ApiSuccessResponse(
                data: $event->toArray(),
                message: 'Nome na lista de evento criada com sucesso!'
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: 'Erro ao tentar criar um nome na lista de evento.',
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
    public function update(EventListItemUpdateRequest $request)
    {
        try {
            // Aqui eu chamo o Action
            // Action é a camada de negócio, chama repository, create log, send mail e etc.
            $data = $request->validationData();
            $data['updated_by'] = Auth::id();
            $event = $this->eventListItemAction->update(id: $request->route('id'), data: $data);

            return new ApiSuccessResponse(
                data: $event->toArray(),
                message: 'Nome na lista de evento atualizada com sucesso!'
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: 'Erro ao tentar atualizar um nome na lista de evento.',
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
    public function delete(EventListItemDeleteRequest $request)
    {
        try {
            // Aqui eu chamo o Action
            // Action é a camada de negócio, chama repository, create log, send mail e etc.
            if(!$this->eventListItemAction->delete(id: $request->route('id'))) {
                throw new EventListItemDeleteException();
            }

            return new ApiSuccessResponse(
                [],
                message: 'Nome na lista de evento deletada com sucesso!'
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(
                exception: $e,
                message: 'Erro ao tentar deletar um nome na lista de evento.',
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
                $this->eventListItemBiAction->all(),
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
