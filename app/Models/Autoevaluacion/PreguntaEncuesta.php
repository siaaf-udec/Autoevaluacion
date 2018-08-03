<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;

class PreguntaEncuesta extends Model
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
    protected $table = 'TBL_Preguntas_Encuestas';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_PEN_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_PEN_Id', 'created_at', 'updated_at'];

    public function preguntas()
    {
        return $this->belongsTo(Pregunta::class, 'FK_PEN_Pregunta', 'PK_PGT_Id');
    }
    public function grupos()
    {
        return $this->belongsto(GrupoInteres::class, 'FK_PEN_GrupoInteres', 'PK_GIT_Id');
    }
    public function banco()
    {
        return $this->belongsTo(BancoEncuestas::class, 'FK_PEN_Banco_Encuestas', 'PK_BEC_Id');
    }
}
