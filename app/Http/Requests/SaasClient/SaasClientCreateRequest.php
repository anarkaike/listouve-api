<?php

namespace App\Http\Requests\SaasClient;

use Illuminate\{Validation\Rule, Validation\Rules\Enum};
use App\Enums\SaasClient\SaasClientStatusEnum;
use App\Http\Requests\BaseFormRequest;

class SaasClientCreateRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255',],
            'email' => ['nullable', 'string', 'email', Rule::unique(table: 'users', column: 'email')->withoutTrashed(),],
            'url_logo_up' => ['nullable', 'file',],
            'phone' => ['nullable', 'string', 'max:20',],
            'observation' => ['nullable', 'string',],
            'status' => ['nullable', new Enum(SaasClientStatusEnum::class)],
        ];

    }
}
