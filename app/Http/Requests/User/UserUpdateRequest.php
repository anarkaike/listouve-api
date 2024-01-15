<?php

namespace App\Http\Requests\User;

use Illuminate\{
    Validation\Rule,
    Validation\Rules\Enum,
};
use App\Enums\User\UserStatusEnum;
use App\Http\Requests\BaseFormRequest;

class UserUpdateRequest extends BaseFormRequest
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
            'password' => ['nullable', 'string', 'max:255',],
            'phone' => ['nullable', 'string', 'max:255',],
            'url_photo_up' => ['nullable', 'file'],
            'status' => ['nullable', new Enum(UserStatusEnum::class)],
            'profiles' => ['nullable'],
            'saas_client_id' => ['nullable'],
        ];
    }
}
