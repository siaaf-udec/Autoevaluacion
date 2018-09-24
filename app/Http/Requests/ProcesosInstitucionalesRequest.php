<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use App\Models\Autoevaluacion\Proceso;

class ProcesosInstitucionalesRequest extends FormRequest
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
            'PCS_Nombre' => 'required',
            'PK_FSS_Id' => 'exists:TBL_Fases',
            'PK_LNM_Id' => 'exists:TBL_Lineamientos'
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
            'PCS_Nombre.required' => 'Nombre requerido.',
            'PK_FSS_Id.exists' => 'La fase que selecciono no se encuentra en nuestros registros',
            'PK_LNM_Id.exists' => 'El lineamiento que selecciono no se encuentra en nuestros registros'
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $id = $this->route()->parameter('procesos_institucionale');
           
            $fechaInicio = Carbon::createFromFormat('d/m/Y', $this->request->get('PCS_FechaInicio'));
            $fechaFin = Carbon::createFromFormat('d/m/Y', $this->request->get('PCS_FechaFin'));
            if ($fechaInicio >= $fechaFin) {
                $validator->errors()->add('Error', 'La fecha de finalización del proceso tiene que ser mayor que la fecha de inicio');
            }

            $procesos_institucionales = Proceso::where('PCS_Institucional', '=', 1)
                ->where('FK_PCS_Fase', '!=', '1')
                ->where('FK_PCS_Fase', '!=', '2')
                ->where('PK_PCS_Id', '!=', $id)
                ->get();

            if ($procesos_institucionales->isNotEmpty()) {
                $validator->errors()->add('Error', 'Solo puede haber un proceso institucional en curso.');
            }

            if ($this->method() == 'PUT'){
                $proceso = Proceso::find($id);
                if($proceso->FK_PCS_Fase != 3 && $proceso->FK_PCS_Lineamiento != $this->request->get('PK_LNM_Id')){
                    $validator->errors()->add('Error', 'El lineamiento no se puede cambiar después de iniciado el proceso.');
                }
            }


        });
    }
}
