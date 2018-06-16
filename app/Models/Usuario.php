<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    /**
     * Tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'TBL_Usuarios';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_USU_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_ACT_Id', 'created_at', 'updated_at', 'remember_token'];

    /**
     * Atributos que no deben ser mostrados.
     *
     * @var array
     */
    protected $hidden = ['USU_Clave', 'remember_token'];
}
