<?php

namespace App\Http\Requests\EventListItem;

use Illuminate\{
    Foundation\Http\FormRequest,
    Validation\Rule,
    Validation\Rules\Enum,
};
use App\Enums\EventListItem\EventListItemPaymentStatusEnum;

/**
 * Classe com as validações do end point de criação de items/nomes na lista de evento
 */
class EventListItemCreateRequest extends FormRequest
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
            'event_list_id' => ['required', 'integer', Rule::exists(table: 'events_lists', column: 'id'),],
            'name' => ['required', 'string', 'max:255',],
            'email' => ['nullable', 'string', 'max:255',],
            'phone' => ['nullable', 'string', 'max:20',],
            'payment_status' => ['nullable', new Enum(EventListItemPaymentStatusEnum::class)],
            'saas_client_id' => ['required', 'integer'],
        ];
    }
}
