<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ReporteAsambleistaPeriodoRequest extends Request
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
            'periodo' => 'required|max:50'
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
            'periodo.required' => 'El periodo es requerido'
        ];
    }
}
