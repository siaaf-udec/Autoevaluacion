<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class DocumentoAutoevaluacion extends Model
{
    /**
     * Tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'TBL_Documentos_Autoevaluacion';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_DOA_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_DOA_Id', 'created_at', 'updated_at'];

    public function archivo()
    {
        return $this->belongsTo(Archivo::class, 'FK_DOA_Archivo', 'PK_ACV_Id');
    }

    public function proceso()
    {
       return $this->belongsTo(Proceso::class, 'FK_DOA_Proceso', 'PK_PCS_Id');
    }

    public function indicadorDocumental()
    {
        return $this->belongsTo(IndicadorDocumental::class, 'FK_DOA_IndicadorDocumental', 'PK_IDO_Id');
    }

    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'FK_DOA_TipoDocumento', 'PK_TDO_Id');
    }

    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class, 'FK_DOA_Dependencia', 'PK_DPC_Id');
    }
}
