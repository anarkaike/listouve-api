<?php

namespace App\Http\Requests\SaasClient;

use App\Enums\SaasClient\SaasClientStatusEnum;
use Illuminate\{
    Foundation\Http\FormRequest,
    Validation\Rules\Enum,
};

class SaasClientCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255',],
            'email_personal' => ['nullable', 'string', 'email',],
            'email_pofessional' => ['nullable', 'string', 'email',],
            'phone_personal' => ['nullable', 'string', 'max:20',],
            'phone_pofessional' => ['nullable', 'string', 'max:20',],
            'observation' => ['nullable', 'string',],
            'status' => ['nullable', new Enum(SaasClientStatusEnum::class)],
        ];

    }
}
