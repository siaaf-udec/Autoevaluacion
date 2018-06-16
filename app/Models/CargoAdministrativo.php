<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CargoAdministrativo extends Model
{
    /**
     * Tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'TBL_Cargos_Administrativos';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_CAA_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_CAA_Id', 'created_at', 'updated_at'];
}
