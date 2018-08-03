<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Autoevaluacion\Aspecto;
use App\Models\Autoevaluacion\Caracteristica;
use App\Models\Autoevaluacion\Factor;
use Excel;
use Illuminate\Support\Facades\Storage;


class ImportarLineamiento implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

     /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    protected $url_archivo, $id_lineamiento;

    public function __construct($url_archivo, $id_lineamiento)
    {
        $this->url_archivo = $url_archivo;
        $this->id_lineamiento = $id_lineamiento;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $id = $this->id_lineamiento;
            Excel::selectSheets('FACTORES', 'CARACTERISTICAS', 'ASPECTOS')->load(public_path($this->url_archivo), function ($reader) use ($id) {
                // get all rows from the sheet
                $sheets = $reader->all()->toArray();
                $factores = [];

                $count = count($sheets);
                if ($count <= 3 and $count > 0) {
                    //Factores
                    foreach ($sheets[0] as $row) {
                        $factor = new Factor();
                        $factor->FCT_Nombre = $row['nombre'];
                        $factor->FCT_Descripcion = $row['descripcion'];
                        $factor->FCT_Identificador = $row['numero_factor'];
                        $factor->FCT_Ponderacion_Factor = $row['ponderacion'];

                        $factor->FK_FCT_Lineamiento = $this->id_lineamiento;
                        $factor->FK_FCT_Estado = 1;
                        $factor->save();
                        $factores[$row['numero_factor']] = $factor->PK_FCT_Id;
                    }
                }
                if ($count <= 3 and $count > 1) {
                    //Caracteristicas
                    $caracacteristicas = [];
                    foreach ($sheets[1] as $row) {
                        $caracacteristica = new Caracteristica();
                        $caracacteristica->CRT_Nombre = $row['nombre'];
                        $caracacteristica->CRT_Descripcion = $row['descripcion'];
                        $caracacteristica->CRT_Identificador = $row['numero_caracteristica'];
                        $caracacteristica->FK_CRT_Estado = 1;
                        $caracacteristica->FK_CRT_Factor = $factores[$row['factor']];
                        $caracacteristica->save();
                        $caracacteristicas[$row['numero_caracteristica']] = $caracacteristica->PK_CRT_Id;
                    }
                }
                if ($count == 3) {
                    foreach ($sheets[2] as $row) {
                        $aspecto = new Aspecto();
                        $aspecto->ASP_Nombre = $row['nombre'];
                        $aspecto->ASP_Descripcion = $row['descripcion'];
                        $aspecto->ASP_Identificador = $row['identificador'];
                        $aspecto->FK_ASP_Caracteristica = $caracacteristicas[$row['caracteristica']];
                        $aspecto->save();
                    }
                }
            });
        } catch (\Exception $e) {
            
        }finally {
            $ruta = str_replace('storage', 'public', $this->url_archivo);
            Storage::delete($ruta);
        }
    }
}
