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
        $description = 'required|min:5';
        $name = 'required|min:5';
        $id = $this->route()->parameter('grupodocumentos');
        
        if ($this->method() == 'PUT') {
            $description = '';
            $name = '';
        }
        return [
            'GRD_Descripcion' => $description,
            'GRD_Nombre' => $name
        ];
    }
}
