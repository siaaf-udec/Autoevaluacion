<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentosAutoevaluacionRequest extends FormRequest
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
        if ($this->hasFile('archivo') && $this->request->get('DOA_Link') !== null) {
            $archivo = 'file';
            $link = 'file';
        }
        elseif($this->hasFile('archivo')){
            $link = '';
            $archivo = 'file';
        }
        elseif ($this->request->get('DOA_Link') !== null) {
            $link = 'url';
            $archivo = '';

        }


        return [
            'PK_FCT_Id' => 'exists:tbl_factores',
            'PK_CRT_Id' => 'exists:tbl_caracteristicas',
            'PK_IDO_Id' => 'exists:tbl_indicadores_documentales',
            'PK_DPC_Id' => 'exists:tbl_dependencias',
            'PK_TDO_Id' => 'exists:tbl_tipo_documentos',
            'DOA_Numero' => 'numeric',
            'DOA_Anio' => 'numeric',
            'DOA_Link' => $link,
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
            'PK_FCT_Id.exists' => 'El factor que selecciono no existe en nuestros registros.',
            'PK_CRT_Id.exists' => 'La característica que selecciono no existe en nuestros registros.',
            'PK_IDO_Id.exists' => 'El Indicador que selecciono no existe en nuestros registros.',
            'PK_DPC_Id.exists' => 'La dependencia que selecciono no existe en nuestros registros.',
            'PK_TDO_Id.exists' => 'El tipo de documento que selecciono no existe en nuestros registros.',
            'DOA_Numero.numeric' => 'El campo numero debe ser un numero.',
            'DOA_Anio.numeric' =>  'El campo año debe ser un año valido.',
            'archivo.file' => 'El archivo debe ser un archivo valido.',
            'DOA_Link.url' => 'El campo link debe ser un link valido.',
            'DOA_Link.file' => 'Por favor ingrese solo un archivo o un link no ambos.'

        ];
    }
}
