<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Classe com as validações do en point de atualização de eventos
 */
class EventUpdateRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255',],
            'description' => ['nullable', 'string',],
            'url_photo' => ['nullable', 'string', 'max:255',],
            'saas_client_id' => ['nullable', 'integer'],
        ];
    }

    protected function prepareForValidation(){
        $this->merge(['id' => $this->route(param: 'id'),]);
    }
}
