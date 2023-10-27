<?php

namespace App\Http\Requests\User;

use Illuminate\{
    Foundation\Http\FormRequest,
    Validation\Rule,
    Validation\Rules\Enum,
};
use App\Enums\User\UserStatusEnum;

class UserCreateRequest extends FormRequest
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
            'name' => ['nullable', 'string', 'max:255',],
            'email' => ['nullable', 'string', 'email', Rule::unique(table: 'users', column: 'email')->whereNull('deleted_at'),],
            'password' => ['nullable', 'string', 'max:255',],
            'phone_personal' => ['nullable', 'string', 'max:255',],
            'phone_professional' => ['nullable', 'string', 'max:255',],
            'url_photo' => ['nullable', 'string', 'max:255',],
            'status' => ['nullable', new Enum(UserStatusEnum::class)],
        ];
    }
}
