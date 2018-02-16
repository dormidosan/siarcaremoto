<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PropuestaRequest extends Request
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
            'asambleista_id' => 'required',
            'nueva_propuesta' => 'required|max:15',
        ];
    }

    public function messages()
    {
        return [
            'nueva_propuesta.required' => 'La nueva propuesta es requerida',
            'nueva_propuesta.max' => 'La propuesta no debe exceder los 15 caracteres'

        ];
    }
}

