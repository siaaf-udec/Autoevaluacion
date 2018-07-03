<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class DependenceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
 
    public function rules()
    {
      
        $id = $this->route()->parameter('dependencia');
        $dependencia = 'required|string|max:80|unique:tbl_dependencias';

        if ($this->method() == 'PUT') {
            $dependencia = 'required|max:80|'.Rule::unique('tbl_dependencias')->ignore($id, 'PK_DPC_Id');
        }

        return [
            'DPC_Nombre' => $dependencia,
        ];
    }
    public function messages(){
        return[
            'DPC_Nombre.unique'=> 'Esta dependencia ya ha sido registrada',
              ];
    }
}
