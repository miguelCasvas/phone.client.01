<?php

namespace App\Http\Requests\TipoSalida;

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
            'nombreTipoSalida' => ['required'],
            'idCanal' => ['required', 'numeric'],
            'idNotificacion' => ['numeric'],
        ];
    }
}
