<?php

namespace App\Http\Requests\SaasClient;

use Illuminate\{
    Validation\Rules\Enum,
};
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
            'name' => ['nullable', 'string', 'max:255',],
            'email_personal' => ['nullable', 'string', 'email',],
            'email_professional' => ['nullable', 'string', 'email',],
            'phone_personal' => ['nullable', 'string', 'max:20',],
            'phone_professional' => ['nullable', 'string', 'max:20',],
            'observation' => ['nullable', 'string',],
            'status' => ['nullable', new Enum(SaasClientStatusEnum::class)],
        ];
    }
}
