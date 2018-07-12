<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\PreguntaEncuesta;
use App\Models\Encuesta;
use App\Models\Proceso;
use App\Models\GrupoInteres;

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
            'PK_BEC_Id' => 'required|exists:tbl_banco_encuestas',
        ];
    }
    public function messages()
    {
        return [
            'PK_PGT_Id.required' => 'Pregunta requerida',
            'PK_BEC_Id.required' => 'Encuesta requerida',
            'PK_PGT_Id.exists' => 'La pregunta que selecciono no se encuentra en nuestros registros',
            'PK_BEC_Id.exists' => 'La encuesta que selecciono no se encuentra en nuestros registros',
            
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
            foreach($this->request->get('gruposInteres') as $grupo => $valor)
            {
                $verificar = PreguntaEncuesta::where('FK_PEN_Pregunta',$this->request->get('PK_PGT_Id'))
                ->where('FK_PEN_Banco_Encuestas',$this->request->get('PK_BEC_Id'))
                ->where('FK_PEN_GrupoInteres',$valor)
                ->first();
                if($verificar)
                {
                    $grupos = GrupoInteres::where('PK_GIT_Id',$valor)->first();
                    $validator->errors()->add('Error', 'Ya existe la pregunta seleccionada para el grupo de interes de '.$grupos->GIT_Nombre);
                }
            }
        });
    }
}

