<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\PreguntaEncuesta;
use App\Models\Encuesta;

class SolucionEncuestaRequest extends FormRequest
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
            $id_encuesta = Encuesta::where('FK_ECT_Proceso','=',session()->get('pk_encuesta'))->first();
            $preguntas = PreguntaEncuesta::whereHas('preguntas', function ($query) {
                return $query->where('FK_PGT_Estado', '1');
            })
            ->with('preguntas')
            ->where('FK_PEN_GrupoInteres', '=', session()->get('pk_grupo'))
            ->where('FK_PEN_Banco_Encuestas', '=', $id_encuesta->FK_ECT_Banco_Encuestas)
            ->get();
            foreach($preguntas as $pregunta){
                $valor = $this->request->get($pregunta->preguntas->PK_PGT_Id,false);
                if ($valor == 0) {
                    $validator->errors()->add('Error', 'Asegurese de seleccionar una respuesta para cada pregunta realizada');
                }
            }           
        });
    }
}
