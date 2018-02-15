<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ReportesRequest extends Request
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
            'tipoDocumento' => 'required|max:50'
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
            'tipoDocumento.required' => 'El nombre es requerido'
        ];
    }
}
