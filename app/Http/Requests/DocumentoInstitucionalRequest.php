<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentoInstitucionalRequest extends FormRequest
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
        $archivo = "required";
        $link = "required";
        if ($this->hasFile('archivo') && $this->request->get('link') !== null) {
            $archivo = 'file';
            $link = 'file';
        }
        elseif($this->hasFile('archivo')){
            $link = '';
            $archivo = 'file';
        }
        elseif ($this->request->get('link') !== null) {
            $link = 'url';
            $archivo = '';

        }


        return [
            'PK_GRD_Id' => 'exists:tbl_grupos_documentos',
            'link' => $link,
            'archivo' => $archivo
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
            'PK_GRD_Id.exists' => 'El grupo de documentos que selecciono no existe en nuestros registros.',
            'archivo.file' => 'El archivo debe ser un archivo valido.',
            'link.url' => 'El campo link debe ser un link valido.',
            'link.file' => 'Por favor ingrese solo un archivo o un link no ambos.'

        ];
    }
}