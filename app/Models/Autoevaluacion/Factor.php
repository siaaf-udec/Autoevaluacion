<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use App\Models\Autoevaluacion\Estado;
use App\Models\Autoevaluacion\Lineamiento;
use App\Models\Autoevaluacion\Caracteristica;

class Factor extends Model
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
    protected $table = 'TBL_Factores';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_FCT_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_FCT_Id', 'created_at', 'updated_at'];
    
    public function estado()
    {
        return $this->hasOne(Estado::class,'PK_ESD_Id','FK_FCT_Estado');
    }
    public function lineamiento()
    {
        return $this->hasOne(Lineamiento::class,'PK_LNM_Id','FK_FCT_Lineamiento');
    }
    public function caracteristica()
    {
        return $this->hasMany(Caracteristica::class,'FK_CRT_Factor','PK_FCT_Id');
    }
}
