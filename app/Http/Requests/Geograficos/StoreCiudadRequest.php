<?php

namespace App\Http\Requests\Geograficos;

use Illuminate\Foundation\Http\FormRequest;

class StoreCiudadRequest extends FormRequest
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
            'idPais' => ['required', 'numeric'],
            'idDepartamento' => ['required', 'numeric'],
            'nombreCiudad'=>['required']
        ];
    }
}
