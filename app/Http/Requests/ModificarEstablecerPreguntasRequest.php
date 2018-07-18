<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Encuesta;
use App\Models\Proceso;

class ModificarEstablecerPreguntasRequest extends FormRequest
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
            $id_proceso = Encuesta::where('PK_ECT_Id',session()->get('id_encuesta'))->first();
            $proceso = Proceso::with('fase')->
            where('PK_PCS_Id',$id_proceso->FK_ECT_Proceso)
            ->first();
            if ($proceso->fase->FSS_Nombre != "construccion") {
                $validator->errors()->add('Error', 'No se puede modificar ya que la encuesta se encuentra relacionada a un proceso en fase diferente de construccion!');
            }
        });
    }
}