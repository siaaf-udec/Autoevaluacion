<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use App\Models\Autoevaluacion\Proceso;

class Fase extends Model
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
    protected $table = 'TBL_Fases';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_FSS_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_FSS_Id', 'created_at', 'updated_at'];

    public function proceso()
    {
        return $this->hasMany(Proceso::class, 'FK_PCS_Fase', 'PK_FSS_Id');
    }
}
