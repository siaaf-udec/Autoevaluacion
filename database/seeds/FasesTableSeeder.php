<?php

use Illuminate\Database\Seeder;
use App\Models\Autoevaluacion\Fase;

class FasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Fase::insert([
            ['FSS_Nombre' => 'cerrado', 'FSS_Descripcion' => 'Descripcion'],
            ['FSS_Nombre' => 'suspendido', 'FSS_Descripcion' => 'Descripcion'],
            ['FSS_Nombre' => 'construccion', 'FSS_Descripcion' => 'Descripcion'],
            ['FSS_Nombre' => 'captura de datos', 'FSS_Descripcion' => 'Descripcion'],
            ['FSS_Nombre' => 'consolidacion', 'FSS_Descripcion' => 'Descripcion'],
            ['FSS_Nombre' => 'plan de mejoramiento', 'FSS_Descripcion' => 'Descripcion']
        ]);
    }
}
