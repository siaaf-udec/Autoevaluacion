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
        
        if ($this->method() == 'PUT') {
            $email = 'required|email|'.Rule::unique('users')->ignore($id);
            $password = '';
        }
        return [
            'email' => $email,
            'password' => $password,
            'lastname' => 'required'
        ];
    }
}
