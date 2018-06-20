<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
 
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users,id,'.$this->get('id'),
            'password' => 'required|min:3',
            'lastname' => 'required'
        ];
    }
    
}
