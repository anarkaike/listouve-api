<?php

namespace App\Http\Requests\Profile;

use App\Http\Requests\BaseFormRequest;

class ProfileCreateRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255',],
        ];
    }
}
