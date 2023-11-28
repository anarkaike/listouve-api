<?php

namespace App\Http\Requests\EventList;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Classe com as validações do en point de exclusão de listas de eventos
 */
class EventListDeleteRequest extends FormRequest
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
        return [];
    }

    protected function prepareForValidation(){
        $this->merge(['id' => $this->route(param: 'id'),]);
    }
}
