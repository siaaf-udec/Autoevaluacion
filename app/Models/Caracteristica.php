<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caracteristica extends Model
{
    /**
     * Tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'TBL_Caracteristicas';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_CRT_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $fillable = ['CRT_Nombre', 'CRT_Descripcion', 'CRT_Identificador','FK_CRT_Factor','FK_CRT_Estado','FK_CRT_Ambito'];
    protected $guarded = ['PK_CRT_Id', 'created_at', 'updated_at'];

    public function aspecto(){
        return $this->hasMany(Aspecto::class, 'FK_ASP_Caracteristica', 'PK_CRT_Id');
    }
    public function factor(){
        return $this->hasOne(Factor::class, 'PK_FCT_Id', 'FK_CRT_Factor');
    }
    public function estado(){
        return $this->belongsTo(Estado::class, 'FK_CRT_Estado', 'PK_ESD_Id');
    }
    public function ambitoResponsabilidad(){
        return $this->belongsTo(AmbitoResponsabilidad::class, 'FK_CRT_Ambito', 'PK_AMB_Id');
    }
  

}
