<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class CityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'city' => 'required',
        ];
    }

    /**
     * Mensajes personalizados en las validaciones
     *
     * @return Array messages
     */
    public function messages()
    {
        return [
            'city.required' => 'Nombre de la ciudad necesario',
        ];
    }

    /**
    * Método failedValidation sobreescrito para errores personalizados
    * @param  Validator $validator [description]
    * @return [object][object of various validation errors]
    */
    protected function failedValidation(Validator $validator)
    {
        $error = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json($validator->errors(), 422)
        );
    }
}
