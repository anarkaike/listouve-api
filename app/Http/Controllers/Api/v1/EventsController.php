<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Support\Facades\Auth;
use App\Actions\Bi\EventBiAction;
use App\Models\Event;
use App\Exceptions\{
    Event\EventDeleteException,
};
use App\Http\{
    Collections\EventCollection,
    Controllers\Controller,
    Requests\Event\EventCreateRequest,
    Requests\Event\EventUpdateRequest,
    Resources\EventResource,
    Responses\ApiErrorResponse,
    Responses\ApiSuccessResponse
};


class EventsController extends Controller
{
    public function __construct(
        private EventBiAction $eventBiAction,
    )
    {}

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
            $events = Event::get();

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
            $eventCreated = Event::create(attributes: $data);

            return new ApiSuccessResponse(
                data: new EventResource($eventCreated),
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
            $data['updated_values'] = array_diff_assoc($event->toArray(), $data);
            $event->fill(attributes: $data)->update();

            return new ApiSuccessResponse(
                data: new EventResource(Event::find($event->id)),
                message: trans(key: 'messages.events.update_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function destroy(Event $event)
    {
        try {
            if(!$event->delete()) {
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
