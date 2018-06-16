<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dependencia extends Model
{
    /**
     * Tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'TBL_Dependencias';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_DPC_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_DPC_Id', 'created_at', 'updated_at'];
}
