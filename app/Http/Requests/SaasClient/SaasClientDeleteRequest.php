<?php

namespace App\Http\Requests\SaasClient;

use App\Http\Requests\BaseFormRequest;

class SaasClientDeleteRequest extends BaseFormRequest
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
