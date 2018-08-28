<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class DocumentGroupRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route()->parameter('grupodocumento');
        $grupodocumento = 'required|string|max:60|unique:TBL_Grupos_Documentos';

        if ($this->method() == 'PUT') {
            $grupodocumento = 'required|max:60|' . Rule::unique('TBL_Grupos_Documentos')->ignore($id, 'PK_GRD_Id');
        }

        return [
            'GRD_Nombre' => $grupodocumento,
            'GRD_Descripcion' => 'required',
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
            'GRD_Nombre.unique' => 'Este grupo ya ha sido registrado.',
            'GRD_Nombre.required' => 'Nombre requerido.',
        ];
    }
}
