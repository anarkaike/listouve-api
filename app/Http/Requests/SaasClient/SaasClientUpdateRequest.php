<?php

namespace App\Http\Requests\SaasClient;

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
            'name' => ['nullable', 'string', 'max:255',],
            'email' => ['nullable', 'string', 'email', Rule::unique(table: 'users', column: 'email')->ignore($this->id)->withoutTrashed(),],
            'phone' => ['nullable', 'string', 'max:20',],
            'observation' => ['nullable', 'string',],
            'status' => ['nullable', new Enum(SaasClientStatusEnum::class)],
        ];
    }
}
