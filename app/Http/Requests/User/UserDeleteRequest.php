<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseFormRequest;

class UserDeleteRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }
}
