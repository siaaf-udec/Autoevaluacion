<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;

class Facultad extends Model
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
    protected $table = 'TBL_Facultades';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_FCD_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_FCD_Id', 'created_at', 'updated_at'];

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'FK_FCD_Estado', 'PK_ESD_Id');
    }
}
