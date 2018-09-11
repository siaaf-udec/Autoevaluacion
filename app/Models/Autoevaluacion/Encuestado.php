<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;

class Encuestado extends Model
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
    protected $table = 'TBL_Encuestados';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_ECD_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_ECD_Id', 'created_at', 'updated_at'];
    /**
     * Relacion uno a muchos con la tabla grupos de interes, un encuesta solo puede pertenecer 
     * a un grupo de interes, pero un grupo de interes puede tener muchos encuestados.
     *
     */
    public function grupos()
    {
        return $this->belongsTo(GrupoInteres::class, 'FK_ECD_GrupoInteres', 'PK_GIT_Id');
    }
}
