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
            'phone' => $this->phone,
            'url_photo' => $this->url_photo,
            'status' => $this->status,
            'saas_clients' => $this->saas_clients,
            'saas_client_id' => $this->saas_client_id,
            'saas_client_ids' => $this->saas_client_ids,
            'profiles' => $this->profiles,
            'profile_ids' => $this->profile_ids,
            'profile_id' => $this->profile_id,
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
