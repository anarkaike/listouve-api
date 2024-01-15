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
            'starts_at' => ['nullable', 'string', 'max:255',],
            'ends_at' => ['nullable', 'string', 'max:255',],
            'duration_in_hours' => ['nullable', 'integer', 'max:255',],
            'address' => ['nullable', 'string','max:255',],
            'city' => ['nullable', 'string','max:255',],
            'state' => ['nullable', 'string','max:255',],
            'contact_info' => ['nullable', 'string','max:255',],
            'attractions_info' => ['nullable', 'string','max:255',],
            'payment_info' => ['nullable', 'string','max:255',],
            'restrictions_info' => ['nullable', 'string','max:255',],
            'ticket_info' => ['nullable', 'string','max:255',],
            'social_networks' => ['nullable',],
            'description' => ['nullable', 'string',],
            'url_banner_up' => ['nullable', 'file',],
            'saas_client_id' => ['required', 'integer'],
        ];
    }
}
