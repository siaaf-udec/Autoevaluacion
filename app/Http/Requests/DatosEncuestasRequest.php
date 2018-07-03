<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DatosEncuestasRequest extends FormRequest
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
            'DAE_Titulo' => 'required|string',
            'DAE_Descripcion' => 'required',
            'PK_GIT_Id' => 'required|exists:tbl_grupos_interes'
        ];
    }
     /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
        'PK_GIT_Id.required' => 'Debe seleccionar un grupo de interes.',
        'PK_GIT_Id.exists' => 'El grupo de interes que selecciona no existe en nuestros registros.'

        ];
    }
}
