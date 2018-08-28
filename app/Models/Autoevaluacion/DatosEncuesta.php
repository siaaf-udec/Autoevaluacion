<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use App\Models\Autoevaluacion\GrupoInteres;
use App\Models\Autoevaluacion\Encuesta;

class DatosEncuesta extends Model
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

    public function grupos()
    {
        return $this->belongsTo(GrupoInteres::class, 'FK_DAE_GruposInteres', 'PK_GIT_Id');
    }

}
