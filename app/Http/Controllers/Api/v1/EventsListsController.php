<?php

namespace App\Http\Controllers\Api\v1;


use App\Models\EventList;
use App\Actions\{Bi\EventListBiAction, EventListAction,};
use App\Exceptions\{EventList\EventListDeleteException,};
use App\Http\{Collections\EventListCollection,
    Controllers\Controller,
    Requests\EventList\EventListCreateRequest,
    Requests\EventList\EventListDeleteRequest,
    Requests\EventList\EventListUpdateRequest,
    Resources\EventListResource,
    Responses\ApiErrorResponse,
    Responses\ApiSuccessResponse};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class EventsListsController extends Controller
{
    public function __construct(
        private EventListAction $eventListAction,
        private EventListBiAction $eventListBiAction,
    )
    {

    }

    public function show(EventList $eventsList)
    {
        try {
            return new ApiSuccessResponse(
                data: new EventListResource($eventsList),
                message: trans(key: 'messages.events_lists.find_by_id_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function index()
    {
        try {
            $eventsLists = $this->eventListAction->listAll();

            return new ApiSuccessResponse(
                data: EventListCollection::make($eventsLists),
                message: trans(key: 'messages.events_lists.list_all_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function store(EventListCreateRequest $request)
    {
        try {
            $data = $request->validationData();
            $eventList = $this->eventListAction->create(data: $data);

            return new ApiSuccessResponse(
                data: new EventListResource($eventList),
                message: trans(key: 'messages.events_lists.create_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function update(EventListUpdateRequest $request, EventList $eventsList)
    {
        try {
            $data = $request->validationData();
            $eventsList = $this->eventListAction->update(id: $eventsList->id, data: $eventsList->fill($data)->toArray());

            return new ApiSuccessResponse(
                data: new EventListResource($eventsList),
                message: trans(key: 'messages.events_lists.update_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function destroy(EventList $eventsList)
    {
        try {
            if(!$this->eventListAction->delete(id: $eventsList->id)) {
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

    public function bi()
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
