<?php

namespace App\Http\Controllers\Api\v1;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Contracts\Controllers\CrudEventListControllerInterface;
use App\Actions\{
    Bi\EventListBiAction,
    EventListAction,
};
use App\Exceptions\{
    EventList\EventListDeleteException,
    EventList\EventListNotFountException,
};
use App\Http\{Controllers\Controller,
    Requests\EventList\EventListCreateRequest,
    Requests\EventList\EventListDeleteRequest,
    Requests\EventList\EventListUpdateRequest,
    Resources\EventListCollection,
    Resources\EventListResource,
    Responses\ApiErrorResponse,
    Responses\ApiSuccessResponse};


/**
 * Controllers para os en points relacionado a entidade usuário
 */
class EventsListsController extends Controller implements CrudEventListControllerInterface
{
    public function __construct(
        // Obtendo por injeção de dependencia o EventListAction e atribuindo ele como propriedade privada
        private EventListAction $eventListAction,
        private EventListBiAction $eventListBiAction,
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
            $eventList = $this->eventListAction->findById(id: $request->route('id'));

            if (!$eventList) {
                throw new EventListNotFountException();
            }

            return new ApiSuccessResponse(
                data: new EventListResource($eventList),
                message: trans(key: 'messages.events_lists.find_by_id_success')
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
            $eventsLists = $this->eventListAction->listAll();

            return new ApiSuccessResponse(
                data: EventListCollection::make($eventsLists),
                message: trans(key: 'messages.events_lists.list_all_success')
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
    public function create(EventListCreateRequest $request)
    {
        try {

            // Aqui eu chamo o Action
            // Action é a camada de negócio, chama repository, create log, send mail e etc.
            $data = $request->all();
            $data['created_by'] = Auth::id();
            $eventList = $this->eventListAction->create(data: $data);

            return new ApiSuccessResponse(
                data: new EventListResource($eventList),
                message: trans(key: 'messages.events_lists.create_success')
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
    public function update(EventListUpdateRequest $request)
    {
        try {
            // Aqui eu chamo o Action
            // Action é a camada de negócio, chama repository, create log, send mail e etc.
            $data = $request->validationData();
            $data['updated_by'] = Auth::id();
            $eventList = $this->eventListAction->update(id: $request->route('id'), data: $data);

            return new ApiSuccessResponse(
                data: new EventListResource($eventList),
                message: trans(key: 'messages.events_lists.update_success')
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
                message: trans(key: 'messages.events_lists.delete_success')
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
                $this->eventListBiAction->all(),
                message: trans(key: 'messages.events_lists.get_bi_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }
}
