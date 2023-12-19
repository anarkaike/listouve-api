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
            'description' => $this->description,
            'url_photo' => $this->url_photo,
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
