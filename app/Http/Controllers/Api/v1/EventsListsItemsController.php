<?php

namespace App\Http\Controllers\Api\v1;

use App\Actions\Bi\EventListItemBiAction;
use App\Actions\EventListItemAction;
use App\Contracts\Controllers\CrudEventListItemControllerInterface;
use App\Models\EventListItem;
use App\Exceptions\{EventListItem\EventListItemDeleteException, EventListItem\EventListItemNotFountException,};
use App\Http\{Collections\EventListItemCollection,
    Controllers\Controller,
    Requests\EventListItem\EventListItemCreateRequest,
    Requests\EventListItem\EventListItemDeleteRequest,
    Requests\EventListItem\EventListItemUpdateRequest,
    Resources\EventListItemResource,
    Responses\ApiErrorResponse,
    Responses\ApiSuccessResponse};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class EventsListsItemsController extends Controller
{
    public function __construct(
        private EventListItemAction   $eventListItemAction,
        private EventListItemBiAction $eventListItemBiAction,
    )
    {

    }

    public function show(EventListItem $eventsListsItem)
    {
        try {
            return new ApiSuccessResponse(
                data: new EventListItemResource($eventsListsItem),
                message: trans(key: 'messages.events_lists_items.find_by_id_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function index()
    {
        try {
            $eventsListsItems = $this->eventListItemAction->listAll();

            return new ApiSuccessResponse(
                data: EventListItemCollection::make($eventsListsItems),
                message: trans(key: 'messages.events_lists_items.list_all_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function store(EventListItemCreateRequest $request)
    {
        try {
            $data = $request->validationData();
            $eventListItem = $this->eventListItemAction->create(data: $data);

            return new ApiSuccessResponse(
                data: new EventListItemResource($eventListItem),
                message: trans(key: 'messages.events_lists_items.create_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function update(EventListItemUpdateRequest $request, EventListItem $eventsListsItem)
    {
        try {
            $data = $request->validationData();
            $eventsListsItem = $this->eventListItemAction->update(id: $eventsListsItem->id, data: $eventsListsItem->fill($data)->toArray());

            return new ApiSuccessResponse(
                data: new EventListItemResource($eventsListsItem),
                message: trans(key: 'messages.events_lists_items.update_success')
            );

        } catch (\Exception $e) {
            return new ApiErrorResponse(exception: $e);
        }
    }

    public function destroy(EventListItem $eventsListsItem)
    {
        try {
            if(!$this->eventListItemAction->delete(id: $eventsListsItem->id)) {
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

    public function bi()
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
