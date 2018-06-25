<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{

    /**
     * Tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'TBL_Archivos';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_ACV_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    protected $fillable = ['ACV_Nombre', 'ACV_Extension', 'ruta'];
    protected $guarded = ['PK_ACV_Id', 'created_at', 'updated_at'];
    public function documentoinstitucional()
    {
        return $this->hasMany(DocumentoInstitucional::class,'FK_DOI_Archivo','PK_ACV_Id');
    }
}
