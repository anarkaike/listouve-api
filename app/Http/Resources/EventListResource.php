<?php

namespace App\Http\Resources;

use Illuminate\{
    Http\Request,
    Http\Resources\Json\JsonResource,
};
use App\Models\EventList;

/**
 * Classe para padronizar o retorno de dados nos en points da entidade EventList
 */
class EventListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'saas_client_id' => $this->saas_client_id,
            'id' => $this->id,
            'event_id' => $this->event_id,
            'name' => $this->name,
            'description' => $this->description,
            'url_photo' => $this->url_photo,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'updated_values' => $this->updated_values,
            'deleted_at' => $this->deleted_at,
            'deleted_by' => $this->deleted_by,
        ];
    }
}
