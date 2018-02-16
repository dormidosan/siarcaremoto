<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PeriodoRequest extends Request
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
            'nombre_periodo' => 'required',
            'inicio' => 'required'

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
            'nombre_periodo.required' => 'El nombre del periodo es requerido',
            'inicio.required' => 'La fecha de inicio es requerida',
        ];
    }
}