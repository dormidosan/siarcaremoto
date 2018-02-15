<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ComisionRequest extends Request
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
            'nombre' => 'required|max:50'
        ];
    }

    /**
     * Get the error messages that apply to the request
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nombre.required' => 'El nombre de la comision es requerido',
            'nombre.max' => 'El nombre de la comision no debe de exceder los 50 caracteres'

        ];
    }
}
