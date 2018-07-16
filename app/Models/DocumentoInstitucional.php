<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentoInstitucional extends Model
{
    /**
     * Tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'TBL_Documentos_Institucionales';

    /**
     * LLave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'PK_DOI_Id';

    /**
     * Atributos del modelo que no pueden ser asignados en masa.
     *
     * @var array
     */
    
    protected $guarded = ['PK_DOI_Id', 'created_at', 'updated_at'];
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($model) {
            if ($model->archivo) {
                $ruta = str_replace('storage', 'public', $model->archivo->ruta);
                Storage::delete($ruta);
            }
        });
    }
    public function grupodocumento()
    {
        return $this->hasOne(GrupoDocumento::class,'PK_GRD_Id','FK_DOI_GrupoDocumento');
    }
    public function archivo()
    {
        return $this->belongsTo(Archivo::class,'FK_DOI_Archivo','PK_ACV_Id');
    }
}
