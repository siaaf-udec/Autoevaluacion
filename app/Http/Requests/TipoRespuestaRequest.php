<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoRespuestaRequest extends FormRequest
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
            'TRP_TotalPonderacion' => 'required',
            'TRP_CantidadRespuestas' => 'required',
            'TRP_Descripcion' => 'required',
            'PK_ESD_Id' => 'required|exists:tbl_estados'
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
        'PK_ESD_Id.required' => 'Debe seleccionar un estado.',
        'PK_ESD_Id.exists' => 'El estado que seleccionó no existe en nuestros registros.'

        ];
    }
}
