<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encuestado extends Model
{
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
    
    public function grupos()
    {
        return $this->belongsTo(GrupoInteres::class, 'FK_ECD_GrupoInteres', 'PK_GIT_Id');
    }
}
