<?php

use Illuminate\Database\Seeder;
use App\Models\GrupoInteres;

class GruposInteresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GrupoInteres::insert([
            ['GIT_Nombre' => 'ESTUDIANTES','FK_GIT_Estado' => '1'],
            ['GIT_Nombre' => 'DOCENTES','FK_GIT_Estado' => '1'],
            ['GIT_Nombre' => 'DIRECTIVOS ACADEMICOS','FK_GIT_Estado' => '1'],
            ['GIT_Nombre' => 'GRADUADOS','FK_GIT_Estado' => '1'],
            ['GIT_Nombre' => 'ADMINISTRATIVOS','FK_GIT_Estado' => '1'],
            ['GIT_Nombre' => 'EMPLEADORES','FK_GIT_Estado' => '1'],
            ['GIT_Nombre' => 'EQUIPO DEL PROGRAMA','FK_GIT_Estado' => '1'],
            ['GIT_Nombre' => 'EQUIPO INSTITUCIONAL','FK_GIT_Estado' => '1'],
        ]);
    }
}
