<?php

namespace App\Http\Requests\User;

use Illuminate\{
    Validation\Rule,
    Validation\Rules\Enum,
};
use App\Http\Requests\BaseFormRequest;
use App\Enums\User\UserStatusEnum;

class UserCreateRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

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
