<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BancoEncuestas extends Model
{
    
    /**
     * Tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'TBL_Banco_Encuestas';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_BEC_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_BEC_Id', 'created_at', 'updated_at'];

}
