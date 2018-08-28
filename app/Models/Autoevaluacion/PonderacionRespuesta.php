<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;

class PonderacionRespuesta extends Model
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
    protected $table = 'TBL_Ponderacion_Respuestas';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_PRT_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_PRT_Id', 'created_at', 'updated_at'];

    public function tipo()
    {
        return $this->belongsTo(TipoRespuesta::class, 'FK_PRT_TipoRespuestas', 'PK_TRP_Id');
    }
}
