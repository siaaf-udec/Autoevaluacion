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

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['PCS_FechaInicio', 'PCS_FechaFin'];



    public function programa()
    {
        return $this->belongsTo(ProgramaAcademico::class,'FK_PCS_Programa', 'PK_PAC_Id');
    }

    public function fase()
    {
        return $this->hasOne(Fase::class,'PK_FSS_Id','FK_PCS_Fase');
    }

    public function lineamiento()
    {
        return $this->belongsTo(Lineamiento::class, 'FK_PCS_Lineamiento', 'PK_LNM_Id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'tbl_procesos_usuarios', 'FK_PCU_Proceso', 'FK_PCU_Usuario');
    }

    public function encuestas()
    {
        
        return $this->hasOne(Encuesta::class,'FK_ECT_Proceso','PK_PCS_Id');
    }

}
