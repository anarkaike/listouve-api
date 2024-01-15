<?php

namespace App\Http\Resources;

use Illuminate\{
    Http\Request,
    Http\Resources\Json\JsonResource,
};
use App\Models\Event;

class EventResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'saas_client_id' => $this->saas_client_id,
            'id' => $this->id,
            'name' => $this->name,
            'starts_at' => $this->starts_at,
            'ends_at' => $this->ends_at,
            'duration_in_hours' => $this->duration_in_hours,
            'description' => $this->description,
            'url_banner' => $this->url_banner,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'contact_info' => $this->contact_info,
            'attractions_info' => $this->attractions_info,
            'payment_info' => $this->payment_info,
            'restrictions_info' => $this->restrictions_info,
            'ticket_info' => $this->ticket_info,
            'social_networks' => $this->social_networks,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'updated_values' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
