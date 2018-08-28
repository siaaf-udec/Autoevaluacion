<?php

namespace App\Models\Autoevaluacion;

use Illuminate\Database\Eloquent\Model;

class IndicadorDocumental extends Model
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
    protected $table = 'TBL_Indicadores_Documentales';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_IDO_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_IDO_Id', 'created_at', 'updated_at'];

    /**
     * Obtener nombre de la caracteristica con su respectivo identificador.
     *
     * @return string
     */
    public function getNombreIndicadorAttribute()
    {
        return "{$this->IDO_Identificador}. {$this->IDO_Nombre}";
    }

    public function caracteristica()
    {
        return $this->belongsTo(Caracteristica::class, 'FK_IDO_Caracteristica', 'PK_CRT_Id');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'FK_IDO_Estado', 'PK_ESD_Id');
    }

    public function documentosAutoevaluacion()
    {
        return $this->hasMany(DocumentoAutoevaluacion::class, 'FK_DOA_IndicadorDocumental', 'PK_IDO_Id');
    }
}
