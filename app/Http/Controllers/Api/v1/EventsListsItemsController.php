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
use App\Http\{Controllers\Controller,
    Requests\EventListItem\EventListItemCreateRequest,
    Requests\EventListItem\EventListItemDeleteRequest,
    Requests\EventListItem\EventListItemUpdateRequest,
    Resources\EventListItemCollection,
    Resources\EventListItemResource,
    Responses\ApiErrorResponse,
    Responses\ApiSuccessResponse};
use Illuminate\Support\Facades\Auth;

/**
 * Controllers para os en points relacionado a entidade usuário
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
            $eventListItem = $this->eventListItemAction->findById(id: $request->route('id'));

            if (!$eventListItem) {
                throw new EventListItemNotFountException();
            }

            return new ApiSuccessResponse(
                data: new EventListItemResource($eventListItem),
                message: trans(key: 'messages.events_lists_items.find_by_id_success')
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
            $eventsListsItems = $this->eventListItemAction->listAll();

            return new ApiSuccessResponse(
                data: EventListItemCollection::make($eventsListsItems),
                message: trans(key: 'messages.events_lists_items.list_all_success')
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
    public function create(EventListItemCreateRequest $request)
    {
        try {
            // Aqui eu chamo o Action
            // Action é a camada de negócio, chama repository, create log, send mail e etc.
            $data = $request->validationData();
            $data['created_by'] = Auth::id();
            $eventListItem = $this->eventListItemAction->create(data: $data);

            return new ApiSuccessResponse(
                data: new EventListItemResource($eventListItem),
                message: trans(key: 'messages.events_lists_items.create_success')
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
    public function update(EventListItemUpdateRequest $request)
    {
        try {
            // Aqui eu chamo o Action
            // Action é a camada de negócio, chama repository, create log, send mail e etc.
            $data = $request->validationData();
            $data['updated_by'] = Auth::id();
            $eventListItem = $this->eventListItemAction->update(id: $request->route('id'), data: $data);

            return new ApiSuccessResponse(
                data: new EventListItemResource($eventListItem),
                message: trans(key: 'messages.events_lists_items.update_success')
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
                message: trans(key: 'messages.events_lists_items.delete_success')
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
                $this->eventListItemBiAction->all(),
                message: trans(key: 'messages.events_lists_items.get_bi_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }
}
