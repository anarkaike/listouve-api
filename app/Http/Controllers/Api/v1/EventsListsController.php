<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EventList;
use App\Actions\{
    Bi\EventListBiAction,
};
use App\Exceptions\{
    EventList\EventListDeleteException,
};
use App\Http\{Collections\EventListCollection,
    Controllers\Controller,
    Requests\EventList\EventListCreateRequest,
    Requests\EventList\EventListUpdateRequest,
    Resources\EventListResource,
    Responses\ApiErrorResponse,
    Responses\ApiSuccessResponse
};


class EventsListsController extends Controller
{
    public function __construct(
        private EventListBiAction $eventListBiAction,
    )
    {

    }

    public function show(EventList $eventsList)
    {
        try {
            return new ApiSuccessResponse(
                data: new EventListResource(resource: $eventsList),
                message: trans(key: 'messages.events_lists.find_by_id_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function index(Request $request)
    {
        try {
            $eventsLists = EventList::filter($request->get('filters'))->get();

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
            $eventList = EventList::create(attributes: $data);

            return new ApiSuccessResponse(
                data: new EventListResource(resource: $eventList),
                message: trans(key: 'messages.events_lists.create_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function update(EventList $eventsList, EventListUpdateRequest $request)
    {
        try {
            $data = $request->validationData();
//            $data['updated_values'] = array_diff_assoc($eventsList->toArray(), $data);
            $eventsList->update(attributes: $data);

            return new ApiSuccessResponse(
                data: new EventListResource(resource: EventList::find(id: $eventsList->id)),
                message: trans(key: 'messages.events_lists.update_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function destroy(EventList $eventsList)
    {
        try {
            if(!$eventsList->delete()) {
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
