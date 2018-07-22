<?php

use Illuminate\Database\Seeder;
use App\Models\AlcanceAdministrativo;

class AlcancesAdministrativosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AlcanceAdministrativo::insert([
            ['AAD_Alcance' => 'TODOS LOS PROGRAMAS DE FORMACION'],
            ['AAD_Alcance' => 'PROGRAMAS DE SU FACULTAD'],
            ['AAD_Alcance' => 'PROGRAMA RESPECTIVO'],
            ['AAD_Alcance' => 'SEDE RESPECTIVA'],
        ]);
    }
}