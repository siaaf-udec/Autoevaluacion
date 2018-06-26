<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LineamientosRequest extends FormRequest
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
        $archivo = "";
        if($this->hasFile('archivo')){
            $archivo = 'file|mimes:xlsx';
        }
        return [
            'LNM_Nombre' => 'required',
            'LNM_Descripcion' => 'required',
            'archivo' => $archivo
        ];
    }
}
