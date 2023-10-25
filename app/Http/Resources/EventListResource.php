<?php

namespace App\Http\Resources;

use App\Models\EventList;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventListResource extends JsonResource
{
    protected $eventList;

    public function __construct($resource, EventList $eventList)
    {
        parent::__construct($resource);
        $this->eventList = $eventList;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->eventList->id,
            'event_id' => $this->eventList->event_id,
            'name' => $this->eventList->name,
            'description' => $this->eventList->description,
            'url_photo' => $this->eventList->url_photo,
            'created_at' => $this->eventList->created_at,
            'updated_at' => $this->eventList->updated_at,
            'created_by' => $this->eventList->created_by,
            'updated_by' => $this->eventList->updated_by,
            'deleted_by' => $this->eventList->deleted_by,
            'deleted_at' => $this->eventList->deleted_at,
        ];
    }
}
