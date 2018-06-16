<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlcanceAdministrativo extends Model
{

    /**
     * Tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'TBL_Alcances_Administrativos';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_AAD_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_AAD_Id', 'created_at', 'updated_at'];


}
