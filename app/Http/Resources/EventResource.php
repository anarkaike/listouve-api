<?php

namespace App\Http\Resources;

use Illuminate\{
    Http\Request,
    Http\Resources\Json\JsonResource,
};
use App\Models\Event;

/**
 * Classe para padronizar o retorno de dados nos end points da entidade Event
 */
class EventResource extends JsonResource
{
    protected $event;

    public function __construct($resource, Event $event)
    {
        parent::__construct($resource);
        $this->event = $event;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->event->id,
            'name' => $this->event->name,
            'description' => $this->event->description,
            'url_photo' => $this->event->url_photo,
            'created_at' => $this->event->created_at,
            'updated_at' => $this->event->updated_at,
            'created_by' => $this->event->created_by,
            'updated_by' => $this->event->updated_by,
            'deleted_by' => $this->event->deleted_by,
            'deleted_at' => $this->event->deleted_at,
        ];
    }
}
