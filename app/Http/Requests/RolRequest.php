<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;


class RolRequest extends FormRequest
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
        $id = $this->route()->parameter('role');
        $roles = 'required|string|max:50|unique:roles';
        
        if ($this->method() == 'PUT') {
            $roles = 'required|string|max:50|'.Rule::unique('users')->ignore($id);
        }

        return [
            'name' => $roles,
            'permission' => 'required'
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
        'permission.required' => 'El campo permisos es requerido.'
        ];
    }
}
