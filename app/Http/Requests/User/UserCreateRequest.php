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
            'email' => ['nullable', 'string', 'email', Rule::unique(table: 'users', column: 'email')->withoutTrashed(),],
            'password' => ['nullable', 'string', 'max:255',],
            'phone' => ['nullable', 'string', 'max:255',],
            'url_photo_up' => ['nullable', 'file'],
            'status' => ['nullable', new Enum(UserStatusEnum::class)],
            'profiles' => ['nullable'],
            'auto_register' => ['nullable', 'boolean'],
        ];
    }
}
