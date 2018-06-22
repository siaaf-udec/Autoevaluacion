<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // Permisos Superadmin
        Permission::create(['name' => 'VER_USUARIOS']);
        Permission::create(['name' => 'CREAR_USUARIOS']);
        Permission::create(['name' => 'MODIFICAR_USUARIOS']);
        Permission::create(['name' => 'ELIMINAR_USUARIOS']);
        // Permisos Fuentes primarias
        Permission::create(['name' => 'VER_ENCUESTAS']);
        Permission::create(['name' => 'CREAR_ENCUESTAS']);
        Permission::create(['name' => 'MODIFICAR_ENCUESTAS']);
        Permission::create(['name' => 'ELIMINAR_ENCUESTAS']);
        // Permisos Fuentes secundarias
        Permission::create(['name' => 'VER_DEPENDENCIAS']);
        Permission::create(['name' => 'CREAR_DEPENDENCIAS']);
        Permission::create(['name' => 'MODIFICAR_DEPENDENCIAS']);
        Permission::create(['name' => 'ELIMINAR_DEPENDENCIAS']);
        //permisos para grupos de documentos
        Permission::create(['name' => 'VER_GRUPO_DOCUMENTOS']);
        Permission::create(['name' => 'CREAR_GRUPO_DOCUMENTOS']);
        Permission::create(['name' => 'MODIFICAR_GRUPO_DOCUMENTOS']);
        Permission::create(['name' => 'ELIMINAR_GRUPO_DOCUMENTOS']);
         //permisos para factores
         Permission::create(['name' => 'VER_FACTORES']);
         Permission::create(['name' => 'CREAR_FACTORES']);
         Permission::create(['name' => 'MODIFICAR_FACTORES']);
         Permission::create(['name' => 'ELIMINAR_FACTORES']);

    }
}
