<?php

namespace App\Http\Requests\Usuario;

use App\Http\Requests\FormRequestToAPI\FormRequestToAPI;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'fechaNacimiento' => ['required', 'date_format:Y-m-d'],
            'identificacion' => ['required', 'min:7'],
            'nombres' => ['required'],
            'apellidos' => ['required'],
            'correo' => ['required', 'email'],
            'contrasenia' => ['required', 'confirmed'],
            'idRol' => ['required', 'numeric'],
            'idConjunto' => ['required', 'numeric'],
        ];
    }

}
