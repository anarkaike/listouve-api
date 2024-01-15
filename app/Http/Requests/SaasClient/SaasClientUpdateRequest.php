<?php

namespace App\Http\Requests\SaasClient;

use App\Enums\SaasClient\SaasClientBusinessSectorEnum;
use Illuminate\{Validation\Rule, Validation\Rules\Enum};
use App\Http\Requests\BaseFormRequest;
use App\Enums\SaasClient\SaasClientStatusEnum;

class SaasClientUpdateRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_name' => ['nullable', 'string', 'max:255',],
            'contact_name' => ['nullable', 'string', 'max:255',],
            'domain_api' => ['nullable', 'string', 'max:255',],
            'domain_front' => ['nullable', 'string', 'max:255',],
            'email' => ['nullable', 'string', 'email', Rule::unique(table: 'users', column: 'email')->ignore($this->id)->withoutTrashed(),],
            'url_logo_up' => ['nullable', 'file',],
            'phone' => ['nullable', 'string', 'max:20',],
            'observation' => ['nullable', 'string',],
            'general_settings' => ['nullable', 'text',],
            'status' => ['nullable', new Enum(SaasClientStatusEnum::class)],
            'business_sector' => ['nullable', new Enum(SaasClientBusinessSectorEnum::class)],
        ];
    }
}
