<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    /**
     * Tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'TBL_Estados';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_ESD_Id';

    /**
     * Indica si el modelo tiene timestamps(update_at, created_at)
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_ESD_Id', 'created_at', 'updated_at'];
}
