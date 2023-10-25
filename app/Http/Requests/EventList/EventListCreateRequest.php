<?php

namespace App\Http\Requests\EventList;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EventListCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
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
