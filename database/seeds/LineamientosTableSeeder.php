<?php

use Illuminate\Database\Seeder;
use App\Models\Lineamiento;

class LineamientosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Lineamiento::insert([
            ['LNM_Nombre' => 'PREGADO', 'LNM_Descripcion' => 'DESCRIPCION'],
            ['LNM_Nombre' => 'POSTGRADO', 'LNM_Descripcion' => 'DESCRIPCION'],
            ['LNM_Nombre' => 'MAESTRIA', 'LNM_Descripcion' => 'DESCRIPCION'],
        ]);
    }
}