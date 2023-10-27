<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Classe com as validações do end point de exclusão de eventos
 */
class EventDeleteRequest extends FormRequest
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
