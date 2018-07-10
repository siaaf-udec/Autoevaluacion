<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreguntaEncuesta extends Model
{
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
}
