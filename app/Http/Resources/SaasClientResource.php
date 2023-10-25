<?php

namespace App\Http\Resources;

use App\Models\saasClient;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaasClientResource extends JsonResource
{
    protected $saasClients;

    public function __construct($resource, saasClient $saasClients)
    {
        parent::__construct($resource);
        $this->saasClients = $saasClients;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->saasClients->id,
            'event_id' => $this->saasClients->event_id,
            'name' => $this->saasClients->name,
            'description' => $this->saasClients->description,
            'url_photo' => $this->saasClients->url_photo,
            'created_at' => $this->saasClients->created_at,
            'updated_at' => $this->saasClients->updated_at,
            'created_by' => $this->saasClients->created_by,
            'updated_by' => $this->saasClients->updated_by,
            'deleted_by' => $this->saasClients->deleted_by,
            'deleted_at' => $this->saasClients->deleted_at,
        ];
    }
}
