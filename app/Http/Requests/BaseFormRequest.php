<?php

namespace App\Http\Requests;

use Illuminate\{
    Foundation\Http\FormRequest,
    Http\Exceptions\HttpResponseException,
    Contracts\Validation\Validator,
};

class BaseFormRequest extends FormRequest
{

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }

//    protected function prepareForValidation(){
//        $this->merge(['id' => $this->route(param: 'id'),]);
//    }
}
