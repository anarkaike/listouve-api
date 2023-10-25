<?php

namespace App\Http\Requests\EventListItem;

use App\Enums\EventListItem\EventListItemPaymentStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class EventListItemUpdateRequest extends FormRequest
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
            'event_id' => ['nullable', 'integer', Rule::exists(table: 'events', column: 'id'),],
            'event_list_id' => ['nullable', 'integer', Rule::exists(table: 'events_lists', column: 'id'),],
            'name' => ['nullable', 'string', 'max:255',],
            'email' => ['nullable', 'string', 'max:255',],
            'phone' => ['nullable', 'string', 'max:20',],
            'payment_status' => ['nullable', new Enum(EventListItemPaymentStatusEnum::class)],
            'saas_client_id' => ['nullable', 'integer'],
        ];
    }
}
