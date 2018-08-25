<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;

class Caracteristica extends Model
{
    /**
     * Conexión usada por el modelo.
     *
     * @var string
     */
    protected $connection = 'autoevaluacion';
    
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
    protected $guarded = ['PK_CRT_Id', 'created_at', 'updated_at'];

    /**
     * Obtener nombre de la caracteristica con su respectivo identificador.
     *
     * @return string
     */
    public function getNombreCaracteristicaAttribute()
    {
        return "{$this->CRT_Identificador}. {$this->CRT_Nombre}";
    }

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

    public function indicadores_documentales()
    {
        return $this->hasMany(IndicadorDocumental::class, 'FK_IDO_Caracteristica', 'PK_CRT_Id');
    }
    public function preguntas()
    {
        return $this->hasMany(Pregunta::class, 'FK_PGT_Caracteristica', 'PK_CRT_Id');
    }
  

}
