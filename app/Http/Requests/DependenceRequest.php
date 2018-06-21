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
        $name = 'required|min:5';
        $id = $this->route()->parameter('dependencia');
        
        if ($this->method() == 'PUT') {
            $name = '';
        }
        return [
            'DPC_Nombre' => $name
        ];
    }
}
