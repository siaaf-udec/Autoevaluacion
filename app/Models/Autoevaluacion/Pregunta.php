<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
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
    protected $table = 'TBL_Preguntas';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_PGT_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_PGT_Id', 'created_at', 'updated_at'];

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'FK_PGT_Estado', 'PK_ESD_Id');
    }

    public function tipo()
    {
        return $this->belongsTo(TipoRespuesta::class, 'FK_PGT_TipoRespuesta', 'PK_TRP_Id');
    }

    public function caracteristica()
    {
        return $this->belongsTo(Caracteristica::class, 'FK_PGT_Caracteristica', 'PK_CRT_Id');
    }

    public function respuestas()
    {
        return $this->hasMany(RespuestaPregunta::class, 'FK_RPG_Pregunta', 'PK_PGT_Id');
    }

    public function preguntas_encuesta()
    {
        return $this->hasMany(PreguntaEncuesta::class, 'FK_PEN_Pregunta', 'PK_PGT_Id');
    }

}
