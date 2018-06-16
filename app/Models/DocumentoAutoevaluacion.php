<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentoAutoevaluacion extends Model
{
    /**
     * Tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'TBL_Documentos_Autoevaluacion';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_DOA_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_DOA_Id', 'created_at', 'updated_at'];
}
