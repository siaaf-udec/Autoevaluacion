<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Estado;
use App\Models\Lineamiento;

class Factor extends Model
{
    /**
     * Tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'TBL_Factores';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_FCT_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_FCT_Id', 'created_at', 'updated_at'];
    
    public function estado()
    {
        return $this->hasOne(Estado::class,'PK_ESD_Id','FK_FCT_Estado');
    }
    public function lineamiento()
    {
        return $this->hasOne(Lineamiento::class,'PK_LNM_Id','FK_FCT_Lineamiento');
    }
}
