<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AmbitoRequest extends FormRequest
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
        $id = $this->route()->parameter('ambito');
        $ambito = 'required|string|max:60|unique:tbl_ambitos_responsabilidad';

        if ($this->method() == 'PUT') {
            $ambito = 'required|max:60|'.Rule::unique('tbl_ambitos_responsabilidad')->ignore($id, 'PK_AMB_Id');
        }

        return [
            'AMB_Nombre' => $ambito,
        ];
    }
    public function messages(){
        return[
            'AMB_Nombre.unique'=> 'Este ambito ya ha sido registrado',
              ];
    }
}
