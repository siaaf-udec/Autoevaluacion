<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

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
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $fechaInicio = Carbon::createFromFormat('d/m/Y', $this->request->get('PCS_FechaInicio'));
            $fechaFin = Carbon::createFromFormat('d/m/Y', $this->request->get('PCS_FechaFin'));
            if ($fechaInicio >= $fechaFin) {
                $validator->errors()->add('Error', 'La fecha de finalización del proceso tiene que ser mayor que la fecha de inicio');
            }
        });
    }
}
