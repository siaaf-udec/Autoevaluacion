<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
 
    public function rules()
    {
        $email = 'required|email|unique:users';
        $password = 'required|min:3';
        $id = $this->route()->parameter('usuario');
        $cedula = "required|numeric|max:9999999999|unique:users";
        
        if ($this->method() == 'PUT') {
            $email = 'required|email|'.Rule::unique('users')->ignore($id);
            $cedula = 'required|numeric|'.Rule::unique('users')->ignore($id);
            $password = '';
        }
        return [
            'email' => $email,
            'password' => $password,
            'name' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'cedula' => $cedula,
            'PK_ESD_Id' => 'required|numeric|exists:tbl_estados'
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
        'cedula.unique' => 'Esta cedula ya ha sido registrada.',
        'PK_ESD_Id.required'  => 'El estado es requerido',
        'PK_ESD_Id.numeric'  => 'Estado invalido.',
        'PK_ESD_Id.exists'  => 'Este estado no existe en nuestros registros.',
        ];
    }
}
