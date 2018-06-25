<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DocumentoInstitucional;

class GrupoDocumento extends Model
{
    /**
     * Tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'TBL_Grupos_Documentos';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_GRD_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $guarded = ['PK_GRD_Id', 'created_at', 'updated_at'];
    public function documentoinstitucional()
    {
        return $this->hasMany(DocumentoInstitucional::class,'FK_DOI_GrupoDocumento','PK_GRD_Id');
    }
}
