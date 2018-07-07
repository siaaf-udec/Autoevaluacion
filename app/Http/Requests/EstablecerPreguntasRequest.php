<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstablecerPreguntasRequest extends FormRequest
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
            'PK_PGT_Id' => 'required|exists:tbl_preguntas',
            'PK_ECT_Id' => 'required|exists:tbl_encuestas',
        ];
    }
    public function messages()
    {
        return [
            'PK_PGT_Id.required' => 'Pregunta requerida',
            'PK_ECT_Id.required' => 'Encuesta requerida',
            'PK_PGT_Id.exists' => 'La pregunta que selecciono no se encuentra en nuestros registros',
            'PK_ECT_Id.exists' => 'La encuesta que selecciono no se encuentra en nuestros registros',
            
        ];
    }
}
