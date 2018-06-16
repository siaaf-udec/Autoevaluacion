<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatosEncuesta extends Model
{
    /**
     * Tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'TBL_Datos_Encuestas';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_DAE_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_DAE_Id', 'created_at', 'updated_at'];
}
