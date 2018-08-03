<?php

use Illuminate\Database\Seeder;
use App\Models\Autoevaluacion\CargoAdministrativo;

class CargosAdministrativosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CargoAdministrativo::insert([
            ['CAA_Cargo' => 'RECTOR','FK_CAA_AlcanceCargo' => '1'],
            ['CAA_Cargo' => 'VICERRECTOR ACADEMICO','FK_CAA_AlcanceCargo' => '1'],
            ['CAA_Cargo' => 'DECANO','FK_CAA_AlcanceCargo' => '2'],
            ['CAA_Cargo' => 'DIRECTOR/COORDINADOR DE PROGRAMA','FK_CAA_AlcanceCargo' => '3'],
            ['CAA_Cargo' => 'DIRECTOR POSGRADOS','FK_CAA_AlcanceCargo' => '1'],
            ['CAA_Cargo' => 'DIRECTOR/COORDINADOR DE INVESTIGACION','FK_CAA_AlcanceCargo' => '1'],
            ['CAA_Cargo' => 'DIRECTOR/COORDINADOR DE EXTENSION','FK_CAA_AlcanceCargo' => '4'],
            ['CAA_Cargo' => 'DIRECTOR/COORDINADOR DE INTERNACIONALIZACION','FK_CAA_AlcanceCargo' => '1'],
            ['CAA_Cargo' => 'DIRECTOR/COORDINADOR DE BIENESTAR','FK_CAA_AlcanceCargo' => '1'],
        ]);
    }
}
