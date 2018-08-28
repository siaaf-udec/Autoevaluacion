<?php

use Illuminate\Database\Seeder;
use App\Models\Autoevaluacion\Estado;

class EstadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Estado::insert([
            ['ESD_Nombre' => 'HABILITADO', 'ESD_Valor' => '1'],
            ['ESD_Nombre' => 'DESHABILITADO', 'ESD_Valor' => '0']
        ]);
    }
}
