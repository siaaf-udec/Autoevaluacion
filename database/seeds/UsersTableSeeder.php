<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\Usuario;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = Usuario::create([
            'USU_Nombre' => 'Claudia',
            'USU_Apellido' => 'admin',
            'USU_Correo' => 'claudia@app.com',
            'USU_Clave' => bcrypt('123456')
        ]);
        $user1->assignRole('SUPERADMIN');

        $user1 = Usuario::create([
            'USU_Nombre' => 'Alejandro',
            'USU_Apellido' => '2',
            'USU_Correo' => 'alejo@app.com',
            'USU_Clave' => bcrypt('123456')
        ]);
        $user1->assignRole('FUENTES_PRIMARIAS');

        $user1 = Usuario::create([
            'USU_Nombre' => 'Liz',
            'USU_Apellido' => 'Quintero',
            'USU_Correo' => 'liz@app.com',
            'USU_Clave' => bcrypt('123456')
        ]);
        $user1->assignRole('FUENTES_SECUNDARIAS');
    }
}
