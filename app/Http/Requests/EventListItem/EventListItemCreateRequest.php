<?php

namespace App\Http\Requests\EventListItem;

use Illuminate\{
    Validation\Rule,
    Validation\Rules\Enum,
};
use App\Http\Requests\BaseFormRequest;
use App\Enums\EventListItem\EventListItemPaymentStatusEnum;


class EventListItemCreateRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_id' => ['required', 'integer', Rule::exists(table: 'events', column: 'id'),],
            'event_list_id' => ['required', 'integer', Rule::exists(table: 'events_lists', column: 'id'),],
            'name' => ['required', 'string', 'max:255',],
            'email' => ['nullable', 'string', 'max:255',],
            'phone' => ['nullable', 'string', 'max:20',],
            'payment_status' => ['nullable', new Enum(EventListItemPaymentStatusEnum::class)],
        ];
    }
}
