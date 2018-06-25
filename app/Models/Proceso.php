<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sede;
use App\Models\ProgramaAcademico;
use App\Models\Fase;
use App\Models\Encuesta;

class Proceso extends Model
{
    /**
     * Tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'TBL_Procesos';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_PCS_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_PCS_Id', 'created_at', 'updated_at'];

    public function sede()
    {
        return $this->hasOne(Sede::class,'PK_SDS_Id','FK_PCS_Sede');
    }

    public function programa()
    {
        return $this->hasOne(ProgramaAcademico::class,'PK_PAC_Id','FK_PCS_Programa');
    }

    public function fase()
    {
        return $this->hasOne(Fase::class,'PK_FSS_Id','FK_PCS_Fase');
    }

    public function encuesta()
    {
        return $this->hasMany(Encuesta::class,'FK_ECT_Proceso','PK_PCS_Id');
    }
}
