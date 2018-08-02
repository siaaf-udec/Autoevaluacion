<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgramasAcademicosRequest extends FormRequest
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
            'PAC_Nombre' => 'required|max:60',
            'PAC_Descripcion' => 'required',
            'PK_ESD_Id' => 'exists:TBL_Estados|numeric',
            'PK_SDS_Id' => 'exists:TBL_Sedes|numeric',
            'PK_FCD_Id' => 'exists:TBL_Facultades|numeric'
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
            'PAC_Nombre.required' => 'Nombre requerido.',
            'PAC_Nombre.max' => 'El campo nombre debe tener máximo 50 caracteres.',
            'PAC_Descripcion' => 'Descripción requerida.',
            'PK_ESD_Id.required' => 'El estado es requerido.',
            'PK_ESD_Id.numeric' => 'Estado invalido.',
            'PK_ESD_Id.exists' => 'Este estado no existe en nuestros registros.',
            'PK_SDS_Id.required' => 'La sede es requerida.',
            'PK_SDS_Id.numeric' => 'Sede invalida.',
            'PK_SDS_Id.exists' => 'Esta sede no existe en nuestros registros.',
            'PK_FCD_Id.required' => 'La facultad es requerida.',
            'PK_FCD_Id.numeric' => 'Facultad invalida.',
            'PK_FCD_Id.exists' => 'Esta facultad no existe en nuestros registros.',
        ];
    }
}
