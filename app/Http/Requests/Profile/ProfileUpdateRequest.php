<?php

namespace App\Http\Requests\Profile;

use App\Http\Requests\BaseFormRequest;

class ProfileUpdateRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:255',],
        ];
    }
}
