<?php

namespace App\Http\Resources;

use Illuminate\Http\{
    Request,
    Resources\Json\JsonResource,
};
use App\Models\saasClient;

class SaasClientResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email_personal' => $this->email_personal,
            'email_professional' => $this->email_professional,
            'phone_personal' => $this->phone_personal,
            'phone_professional' => $this->phone_professional,
            'observation' => $this->observation,
            'status' => $this->status,
            'general_settings' => $this->general_settings,
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
