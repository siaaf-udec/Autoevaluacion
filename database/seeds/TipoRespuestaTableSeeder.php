<?php

use Illuminate\Database\Seeder;
use App\Models\TipoRespuesta;

class TipoRespuestaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoRespuesta::insert([
            ['TRP_TotalPonderacion' => '10', 'TRP_CantidadRespuestas' => '2', 'TRP_Descripcion' => 'Dos opciones de respuesta','FK_TRP_Estado' => '1'],
            ['TRP_TotalPonderacion' => '10', 'TRP_CantidadRespuestas' => '3', 'TRP_Descripcion' => 'Opciones de respuesta distribuidas (3 opciones)','FK_TRP_Estado' => '1'],
            ['TRP_TotalPonderacion' => '10', 'TRP_CantidadRespuestas' => '4', 'TRP_Descripcion' => 'Opciones de respuesta distribuidas (4 opciones)','FK_TRP_Estado' => '1'],
            ['TRP_TotalPonderacion' => '10', 'TRP_CantidadRespuestas' => '5', 'TRP_Descripcion' => 'Opciones de respuesta distribuidas (5 opciones)','FK_TRP_Estado' => '1'],
            ['TRP_TotalPonderacion' => '10', 'TRP_CantidadRespuestas' => '4', 'TRP_Descripcion' => 'Cuatro opciones de respuesta, las dos ultimas toman valor minimo','FK_TRP_Estado' => '1'],
        ]);
    }
}
