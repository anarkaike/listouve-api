<?php

namespace App\Http\Requests\EventList;

use Illuminate\{
    Validation\Rule,
};
use App\Http\Requests\BaseFormRequest;


class EventListUpdateRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_id' => ['required', 'integer', Rule::exists(table: 'events', column: 'id'),],
            'name' => ['required', 'string', 'max:255',],
            'description' => ['nullable', 'string',],
            'url_photo' => ['nullable', 'string', 'max:255',],
            'saas_client_id' => ['nullable', 'integer'],
        ];
    }
}
