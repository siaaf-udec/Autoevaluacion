<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AmbitoResponsabilidad extends Model
{

  

    /**
     * Tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'TBL_Ambitos_Responsabilidad';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_AMB_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_AMB_Id', 'created_at', 'updated_at'];
}
