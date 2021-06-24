<?php

namespace App\Http\Requests\Manage;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LibrosRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
        //return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:80',//reglas que debe de cumplir este campo
            'idioma' => 'required|max:2000',
            'archivo' => 'required|image|max:1024',
            'description' => 'required|max:2000',
            'genero' => 'required|max:2000',
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'el campo title es requerido',
            'idioma.required' => 'el campo idioma es requerido',
            'archivo.required' => 'el campo archivo es requerido',
            'description.required' => 'el campo description es requerido',
            'genero.required' => 'el campo genero es requerido',
        ];
    }
}
