<?php

namespace App\Http\Requests\Profile;

use App\Http\Requests\BaseFormRequest;

class ProfileDeleteRequest extends BaseFormRequest
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
