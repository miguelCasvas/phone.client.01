<?php

namespace App\Http\Requests\UbicacionCatalogo;

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
            'nombreUbicacionCatalogo' => ['required'],
            'valorExtension' => ['required', 'numeric'],
            'idCatalogo' => ['required','numeric']
        ];
    }

    public function response(array $errors)
    {
        $redireccionamiento =
            parent::response($errors); // TODO: Change the autogenerated stub

        return
            $redireccionamiento->with('formUbicCat_Activo', true);
    }
}
