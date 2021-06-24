<?php

namespace App\Http\Requests\Manage;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
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
            'name' => 'required|string|min:2|max:60',
            'email' => 'required|string|email|max:100|unique:users,email',
            'password' => 'required|string|min:8',
            'password_confirmation' =>'required|string|min:8',
            'rol' => 'required|string'
        ];
    }
    public function messages()
    {
        return [
            //reglas para el campo name
            'name.required' => 'el campo name es requerido',
            'name.min' => 'el campo name debe de tener un minimo de 2 carcteres',
            'name.max' => 'el campo name debe de tener un maximo 60 carcteres',
            

            //reglas para el campo email
            'email.required' => 'el campo email es requerido',
            'email.email' => 'el email ingresado no es correcto',
            'email.max' => 'el campo email debe de tener un maximo de 100 caracteres',
            'email.unique' => 'el email ingresado ya existe',

            //reglas para el campo password
            'password.required' => 'el campo password es requerido',
            'password_confirmation' => 'el campo contraseña es requerido',
            'rol.required' => 'el campo rol es requerido',
            
        ];
    }
}
