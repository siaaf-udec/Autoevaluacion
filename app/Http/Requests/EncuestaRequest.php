<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Proceso;
use Carbon\Carbon;

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
        $id = $this->route()->parameter('datosEspecifico');
        $datos = 'required|unique:tbl_encuestas,fk_ect_proceso';
        
        if ($this->method() == 'PUT') {
            $datos = Rule::unique('tbl_encuestas','fk_ect_proceso')->ignore($id, 'PK_ECT_Id');
        }
        return [
            'ECT_FechaPublicacion' => 'required',
            'ECT_FechaFinalizacion' => 'required',
            'PK_ESD_Id' => 'exists:tbl_estados',
            'PK_PCS_Id' =>  'required|exists:tbl_procesos',
            'PK_PCS_Id' => $datos
        ];
    }
    public function messages()
    {
        return [
            'ECT_FechaPublicacion.required' => 'Fecha de publicacion requerida.',
            'PK_PCS_Id.required' => 'Debe seleccionar un proceso.',
            'ECT_FechaFinalizacion.required' => 'Fecha de finalizacion requerida.',
            'PK_ESD_Id.exists' => 'El estado que selecciono no se encuentra en nuestros registros',
            'PK_PCS_Id.unique' => 'Ya existen datos relacionados al proceso seleccionado.',
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
            $proceso;
            if ( !empty($this->request->get('PK_PCS_Id') ) ) {
                $proceso = Proceso::with('fase')->
                where('PK_PCS_Id',$this->request->get('PK_PCS_Id'))
                ->first();
            if ($proceso->fase->FSS_Nombre != "construccion") {
                $validator->errors()->add('Error', 'El proceso seleccionado no se encuentra en fase de construccion!');
            }
            }
            $fechaInicio = Carbon::createFromFormat('d/m/Y', $this->request->get('ECT_FechaPublicacion'));
            $fechaFin = Carbon::createFromFormat('d/m/Y', $this->request->get('ECT_FechaFinalizacion'));
            if ($fechaInicio >= $fechaFin) 
            {
                $validator->errors()->add('Error', 'La fecha de publicacion tiene que ser menor que la fecha de finalizacion');
            }
        });
    }
}