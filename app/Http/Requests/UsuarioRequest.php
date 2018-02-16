<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UsuarioRequest extends Request
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
            'primer_nombre' => "required|max:15",
            'segundo_nombre' => "required|max:15",
            'primer_apellido' => "required|max:15",
            'segundo_apellido' => "required|max:15",
            'dui' => "required|min:10|max:10",
            'nit' => "required|min:17|max:17",
            'correo' => "required|max:45|email",
            'afp' => "required|min:12|max:12",
            'cuenta' => "required|min:10|max:10",
            'foto' => 'required|mimes:jpeg,png,jpg|max:2048',
            'tipo_usuario' => 'required',
            'sector' => 'required',
            'facultad' => 'required',
            'propietario' => 'required',
            'fecha1' => 'required',
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
            'nombre.max' => 'El nombre de la comision no debe de exceder los 50 caracteres',
            'primer_nombre.max' => "El primer nombre no debe exceder los 15 caracteres",
            'segundo_nombre.max' => "El primer nombre no debe exceder los 15 caracteres",
            'primer_apellido.max' => "El primer nombre no debe exceder los 15 caracteres",
            'segundo_apellido.max' => "El primer nombre no debe exceder los 15 caracteres",
            'correo.email' => "El correo ingresado no es un formato valido",
            'foto.required' => 'Ingrese una fotografia del nuevo usuario',
            'foto.mimes' => 'Solo JPG, PNG o JPEG son formatos validos'


        ];
    }
}
