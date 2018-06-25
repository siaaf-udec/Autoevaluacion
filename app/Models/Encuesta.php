<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Estado;
use App\Models\Proceso;
use App\Models\DatosEncuesta;

class Encuesta extends Model
{
    /**
     * Tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'TBL_Encuestas';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_ECT_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_ECT_Id', 'created_at', 'updated_at'];

    public function estado()
    {
        return $this->hasOne(Estado::class,'PK_ESD_Id','FK_ECT_Estado');
    }

    public function proceso()
    {
        return $this->hasOne(Proceso::class,'PK_PCS_Id','FK_ECT_Proceso');
    }

    public function datos()
    {
        return $this->hasOne(DatosEncuesta::class,'PK_DAE_Id','FK_ECT_DatosEncuesta');
    }
}
