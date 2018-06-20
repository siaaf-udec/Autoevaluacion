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
        $email = 'required|email|unique:users';
        $userId = auth()->user()->id;
        $eje = $this->route('user.name');
        
        if ($this->method() == 'PUT') {
            $email = sprintf('required|email|unique:users,email,%d,id', $userId);
        }
        return [
            'email' => $email,
            'password' => 'required|min:3',
            'lastname' => 'required'
        ];
    }
}
