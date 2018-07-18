<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndicadoresDocumentalesRequest extends FormRequest
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
            'IDO_Nombre' => 'required|string',
            'IDO_Identificador' => 'required|numeric|'.Rule::unique('tbl_indicadores_documentales', 'IDO_Identificador')
            ->where('FK_IDO_Caracteristica', $this->request->get('PK_CRT_Id')),
            'IDO_Descripcion' => 'required',
            'PK_ESD_Id' => 'exists:tbl_estados',
            'PK_CRT_Id' => 'exists:tbl_caracteristicas'
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
            'IDO_Nombre.required' => 'el campo nombre requerido.',
            'IDO_Nombre.string' => 'el campo nombre debe ser un nombre valido.',
            'IDO_Identificador.required' => 'el campo identificador es requerido.',
            'IDO_Identificador.numeric' => 'el campo identificador deber ser numérico.',
            'IDO_Identificador.unique' => 'El identificador que ingreso ya ha sido registrado.',
            'PK_ESD_Id.exists' => 'El estado que selecciono no se encuentra en nuestros registros',
            'PK_CRT_Id.exists' => 'La característica que selecciono no se encuentra en nuestros registros'
        ];
    }
}
