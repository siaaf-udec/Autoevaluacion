<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PreguntasRequest extends FormRequest
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
            'PGT_Texto' => 'required|string',
            'PK_ESD_Id' => 'required|exists:tbl_estados',
            'PK_TRP_Id' => 'required|exists:tbl_tipo_respuestas',
            'PK_CRT_Id' => 'required|exists:tbl_caracteristicas',

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
        'PGT_Texto.required' => 'Debe digitar una respuesta',    
        'PK_ESD_Id.required' => 'Debe seleccionar un estado.',
        'PK_ESD_Id.exists' => 'El estado que selecciona no existe en nuestros registros.',
        'PK_TRP_Id.required' => 'Debe seleccionar un tipo de respuesta.',
        'PK_TRP_Id.exists' => 'El tipo de respuesta que selecciona no existe en nuestros registros.',
        'PK_CRT_Id.required' => 'Debe seleccionar una caracteristica.',
        'PK_CRT_Id.exists' => 'La caracteristica que selecciona no existe en nuestros registros.'

        ];
    }
    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (session()->get('id_proceso')) {
                $validator->errors()->add('field', 'Something is wrong with this field!');
            }
        });
    }
}
