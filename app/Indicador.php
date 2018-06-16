<?php

namespace App\Container\Autoevaluation\src;

use Illuminate\Database\Eloquent\Model;

class Indicador extends Model
{
    /**
     * Tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'TBL_Indicadores';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_EDC_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_EDC_Id', 'created_at', 'updated_at'];
}
