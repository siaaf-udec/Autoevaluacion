<?php

use Illuminate\Database\Seeder;
use App\Models\TipoDocumento;

class TipoDocumentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoDocumento::insert([
            ['TDO_Nombre' => 'ACTA'],
            ['TDO_Nombre' => 'ACUERDO'],
            ['TDO_Nombre' => 'CIRCULAR'],
            ['TDO_Nombre' => 'DECRETO'],
            ['TDO_Nombre' => 'INFORME'],
            ['TDO_Nombre' => 'LEY'],
            ['TDO_Nombre' => 'COMUNICADO'],
            ['TDO_Nombre' => 'RESOLUCION'],
            ['TDO_Nombre' => 'MEMORANDO']
        ]);
    }
}
