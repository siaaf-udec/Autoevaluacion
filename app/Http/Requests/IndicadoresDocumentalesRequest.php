<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'IDO_Identificador' => 'required|numeric',
            'IDO_Descripcion' => 'required',
            'PK_ESD_Id' => 'exists:tbl_estados',
            'PK_CRT_Id' => 'exists:tbl_caracteristicas'
        ];
    }
}
