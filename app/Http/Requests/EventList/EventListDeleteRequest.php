<?php

namespace App\Http\Requests\EventList;

use App\Http\Requests\BaseFormRequest;


class EventListDeleteRequest extends BaseFormRequest
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
