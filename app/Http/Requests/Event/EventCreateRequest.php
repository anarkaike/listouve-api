<?php

namespace App\Http\Requests\Event;

use App\Http\Requests\BaseFormRequest;

class EventCreateRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255',],
            'description' => ['nullable', 'string',],
            'url_photo' => ['nullable', 'string', 'max:255',],
            'saas_client_id' => ['required', 'integer'],
        ];
    }
}
