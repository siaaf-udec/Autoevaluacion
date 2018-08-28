<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use App\Models\Autoevaluacion\DatosEncuesta;
use App\Models\Autoevaluacion\PreguntaEncuesta;

class GrupoInteres extends Model
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
    protected $table = 'TBL_Grupos_Interes';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_GIT_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_GIT_Id', 'created_at', 'updated_at'];

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'FK_GIT_Estado', 'PK_ESD_Id');
    }

    public function preguntas_encuesta()
    {
        return $this->hasMany(PreguntaEncuesta::class, 'FK_PEN_GrupoInteres', 'PK_GIT_Id');
    }
}
