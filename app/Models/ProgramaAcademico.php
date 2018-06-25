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
}
