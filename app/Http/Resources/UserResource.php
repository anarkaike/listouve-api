<?php

namespace App\Http\Resources;

use Illuminate\Http\{
    Request,
    Resources\Json\JsonResource,
};


class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'phone_personal' => $this->phone_personal,
            'phone_professional' => $this->phone_professional,
            'url_photo' => $this->url_photo,
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
