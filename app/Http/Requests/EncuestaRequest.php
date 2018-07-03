<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EncuestaRequest extends FormRequest
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
            'ECT_FechaPublicacion' => 'required',
            'ECT_FechaFinalizacion' => 'required',
            'PK_ESD_Id' => 'exists:tbl_estados',
            'PK_PCS_Id' => 'exists:tbl_procesos',
            'PK_DAE_Id' => 'exists:tbl_datos_encuestas'
        ];
    }
    public function messages()
    {
        return [
            'ECT_FechaPublicacion.required' => 'Fecha de publicacion requerida.',
            'ECT_FechaFinalizacion.required' => 'Fecha de finalizacion requerida.',
            'PK_ESD_Id.exists' => 'El estado que selecciono no se encuentra en nuestros registros',
            'PK_PCS_Id.exists' => 'El proceso que selecciono no se encuentra en nuestros registros',
            'PK_DAE_Id.exists' => 'Los datos generales que selecciono no se encuentran en nuestros registros'
        ];
    }
}
