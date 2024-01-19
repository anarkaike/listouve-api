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
            $eventBuilder = EventList::filter($request->get('filters'));
            if ($request->get('event_id')) {
                $eventBuilder->where('event_id', $request->get('event_id'));
            }
            $eventsLists = $eventBuilder
                ->where('saas_client_id', $this->getSaasClientId())->get();

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
            $data['url_photo'] = $this->upload(paramName: 'url_photo', request: $request);
            $data['saas_client_id'] = $this->getSaasClientId();
            $eventList = EventList::create(attributes: $data);

            return new ApiSuccessResponse(
                data: $eventList->toArray(),
                message: trans(key: 'messages.events_lists.create_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function update(EventList $eventList, EventListUpdateRequest $request)
    {
        try {
            $data = $request->validationData();
            $data['url_photo'] = $this->upload(paramName: 'url_photo', request: $request);
            if(!$eventList->update(attributes: $data)){
                throw new \Exception('Erro ao atualizar');
            }

            return new ApiSuccessResponse(
                data: $eventList->toArray(),
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
