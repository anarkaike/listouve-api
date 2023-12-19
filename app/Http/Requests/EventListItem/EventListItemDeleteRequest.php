<?php

namespace App\Http\Requests\EventListItem;

use App\Http\Requests\BaseFormRequest;


class EventListItemDeleteRequest extends BaseFormRequest
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
