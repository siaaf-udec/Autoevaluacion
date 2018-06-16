<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPrograma extends Model
{
    /**
     * Tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'TBL_Tipo_Programas';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_TPR_Id';

    /**
     * Atributos del modelo que pueden ser asignados en masa.
     *
     * @var array
     */
    protected $fillable = ['TPR_Nombre', 'TPR_Descripcion'];
}
