<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Proceso;

class Sede extends Model
{
    /**
     * Tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'TBL_Sedes';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_SDS_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_SDS_Id', 'created_at', 'updated_at'];

    public function proceso()
    {
        return $this->hasMany(Proceso::class,'FK_PCS_Sede','PK_SDS_Id');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'FK_SDS_Estado', 'PK_ESD_Id');
    }
}
