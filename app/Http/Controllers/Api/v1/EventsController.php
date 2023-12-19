<?php

namespace App\Http\Controllers\Api\v1;

use App\Actions\Bi\EventBiAction;
use App\Actions\EventAction;
use App\Models\Event;
use App\Exceptions\{Event\EventDeleteException, };
use App\Http\{Collections\EventCollection,
    Controllers\Controller,
    Requests\Event\EventCreateRequest,
    Requests\Event\EventDeleteRequest,
    Requests\Event\EventUpdateRequest,
    Resources\EventResource,
    Responses\ApiErrorResponse,
    Responses\ApiSuccessResponse};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class EventsController extends Controller
{
    public function __construct(
        private EventAction $eventAction,
        private EventBiAction $eventBiAction,
    )
    {

    }

    public function show(Event $event)
    {
        try {
            return new ApiSuccessResponse(
                data: new EventResource($event),
                message: trans(key: 'messages.events.find_by_id_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function index()
    {
        try {
            $events = $this->eventAction->listAll();

            return new ApiSuccessResponse(
                data: EventCollection::make($events),
                message: trans(key: 'messages.events.list_all_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function store(EventCreateRequest $request)
    {
        try {
            $data = $request->validationData();
            $event = $this->eventAction->create(data: $data);

            return new ApiSuccessResponse(
                data: new EventResource($event),
                message: trans(key: 'messages.events.create_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function update(EventUpdateRequest $request, Event $event)
    {
        try {
            $data = $request->validationData();
            $event = $this->eventAction->update(id: $event->id, data: $event->fill($data)->toArray());

            return new ApiSuccessResponse(
                data: new EventResource($event),
                message: trans(key: 'messages.events.update_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function destroy(Event $event)
    {
        try {
            if(!$this->eventAction->delete(id: $event->id)) {
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

    public function bi()
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
