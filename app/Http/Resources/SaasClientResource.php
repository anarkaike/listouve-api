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
            'company_name' => $this->company_name,
            'contact_name' => $this->contact_name,
            'domain_api' => $this->domain_api,
            'domain_front' => $this->domain_front,
            'email' => $this->email,
            'phone' => $this->phone,
            'url_logo' => $this->url_logo,
            'url_login_bg' => $this->url_login_bg,
            'url_system_bg' => $this->url_system_bg,
            'observation' => $this->observation,
            'status' => $this->status,
            'business_sector' => $this->business_sector,
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
