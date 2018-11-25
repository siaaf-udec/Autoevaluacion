<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResponsableRequest extends FormRequest
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
        $id = $this->route()->parameter('responsable');
        $responsable = 'unique:tbl_responsables,fk_rps_responsable';

        if ($this->method() == 'PUT') {
            $responsable = Rule::unique('TBL_Responsables', 'fk_rps_responsable')->ignore($id, 'PK_RPS_Id');
        }
        return [
            'id' => 'required|exists:users',
            'id' => $responsable
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
            'id.required' => 'Debe seleccionar un responsable.',
            'id.exists' => 'El usuario que selecciona no existe en nuestros registros.',
            'id.unique' => 'Ya existe el responsable',
        ];
    }
}