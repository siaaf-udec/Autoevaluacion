<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Proceso;

class ProgramaAcademico extends Model
{
    /**
     * Tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'TBL_Programas_Academicos';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_PAC_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_PAC_Id', 'created_at', 'updated_at'];

    public function proceso()
    {
        return $this->hasMany(Proceso::class,'FK_PCS_Programa','PK_PAC_Id');
    }

    public function facultad()
    {
        return $this->belongsTo(Facultad::class, 'FK_PAC_Facultad', 'PK_FCD_Id');
    }
    public function sede()
    {
        return $this->belongsTo(Sede::class, 'FK_PAC_Sede', 'PK_SDS_Id');
    }
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'FK_PAC_Estado', 'PK_ESD_Id');
    }
}
