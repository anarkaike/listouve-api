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
use Illuminate\Support\Facades\Auth;

/**
 * Controllers para os en points relacionado a entidade usuário
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
            $event = $this->eventAction->findById(id: $request->route('id'));

            if (!$event) {
                throw new EventNotFountException();
            }

            return new ApiSuccessResponse(
                data: $event->toArray(),
                message: trans(key: 'messages.events.find_by_id_success')
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
            $event = $this->eventAction->listAll();

            return new ApiSuccessResponse(
                data: $event->toArray(),
                message: trans(key: 'messages.events.list_all_success')
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
    public function create(EventCreateRequest $request)
    {
        try {
            // Aqui eu chamo o Action
            // Action é a camada de negócio, chama repository, create log, send mail e etc.
            $data = $request->validationData();
            $data['updated_by'] = Auth::id();
            $event = $this->eventAction->create(data: $data);

            return new ApiSuccessResponse(
                data: $event->toArray(),
                message: trans(key: 'messages.events.create_success')
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
    public function update(EventUpdateRequest $request)
    {
        try {
            // Aqui eu chamo o Action
            // Action é a camada de negócio, chama repository, create log, send mail e etc.
            $data = $request->validationData();
            $data['updated_by'] = Auth::id();
            $event = $this->eventAction->update(id: $request->route('id'), data: $data);

            return new ApiSuccessResponse(
                data: $event->toArray(),
                message: trans(key: 'messages.events.update_success')
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
                message: trans(key: 'messages.events.delete_success')
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
                $this->eventBiAction->all(),
                message: trans(key: 'messages.events.get_bi_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }
}
