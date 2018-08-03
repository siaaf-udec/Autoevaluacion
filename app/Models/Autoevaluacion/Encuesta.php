<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;
use App\Models\Autoevaluacion\Estado;
use App\Models\Autoevaluacion\BancoEncuestas;

class Encuesta extends Model
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
     /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['ECT_FechaPublicacion', 'ECT_FechaFinalizacion'];
    
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'FK_ECT_Estado', 'PK_ESD_Id');
    }
    public function banco()
    {
        return $this->belongsTo(BancoEncuestas::class, 'FK_ECT_Banco_Encuestas', 'PK_BEC_Id');
    }
    public function proceso()
    {
        return $this->belongsTo(Proceso::class, 'FK_ECT_Proceso', 'PK_PCS_Id');
    }

    
}
