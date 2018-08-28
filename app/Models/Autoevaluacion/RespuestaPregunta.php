<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;

class RespuestaPregunta extends Model
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
    protected $table = 'TBL_Respuestas_Preguntas';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_RPG_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_RPG_Id', 'created_at', 'updated_at'];

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class, 'FK_RPG_Pregunta', 'PK_PGT_Id');
    }

    public function ponderacion()
    {
        return $this->belongsTo(PonderacionRespuesta::class, 'FK_RPG_PonderacionRespuesta', 'PK_PRT_Id');
    }

    public function solucion()
    {
        return $this->hasMany(SolucionEncuesta::class, 'FK_SEC_Respuesta', 'PK_RPG_Id');
    }
}
