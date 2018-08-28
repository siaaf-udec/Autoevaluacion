<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;

class SolucionEncuesta extends Model
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
    protected $table = 'TBL_Solucion_Encuestas';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_SEC_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_SEC_Id', 'created_at', 'updated_at'];

    public function encuestados()
    {
        return $this->belongsTo(Encuestado::class, 'FK_SEC_Encuestado', 'PK_ECD_Id');
    }

    public function respuestas()
    {
        return $this->belongsTo(RespuestaPregunta::class, 'FK_SEC_Respuesta', 'PK_RPG_Id');
    }
}
