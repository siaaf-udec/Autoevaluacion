<?php

namespace App\Models\Historial;

use Illuminate\Database\Eloquent\Model;

class Factor extends Model
{
    /**
     * Conexión usada por el modelo.
     *
     * @var string
     */
    protected $connection = 'historial';

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

    /**
     * Obtener nombre del factor con su respectivo identificador.
     * Funcion que uno los dos campos de identificacion
     * y nombre del factor en una cadena
     *
     * @return string
     */
    public function getNombreFactorAttribute()
    {
        return "{$this->FCT_Identificador}. {$this->FCT_Nombre}";
    }

}
