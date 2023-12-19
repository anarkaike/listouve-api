<?php

namespace App\Http\Requests\Event;

use App\Http\Requests\BaseFormRequest;

class EventDeleteRequest extends BaseFormRequest
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
