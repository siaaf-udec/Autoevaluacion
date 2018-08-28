<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;

class Subgrupo extends Model
{
    /**
     * Conexión usada por el modelo.
     *
     * @var string
     */
    protected $connection = 'autoevaluacion';

    /**
     * Tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'TBL_Subgrupos';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_SGP_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_SGP_Id', 'created_at', 'updated_at'];


}
