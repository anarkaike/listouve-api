<?php

namespace App\Http\Requests\EventListItem;

use Illuminate\{
    Validation\Rule,
    Validation\Rules\Enum,
};
use App\Enums\EventListItem\EventListItemPaymentStatusEnum;
use App\Http\Requests\BaseFormRequest;


class EventListItemUpdateRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

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
