<?php

namespace App\Http\Resources;

use Illuminate\Http\{
    Request,
    Resources\Json\JsonResource,
};

/**
 * Classe para padronizar o retorno de dados nos end points da entidade EventListItem
 */
class EventListItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
