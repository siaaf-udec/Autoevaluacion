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
        Permission::create(['name' => 'ACCEDER_USUARIOS']);
        Permission::create(['name' => 'VER_USUARIOS']);
        Permission::create(['name' => 'CREAR_USUARIOS']);
        Permission::create(['name' => 'MODIFICAR_USUARIOS']);
        Permission::create(['name' => 'ELIMINAR_USUARIOS']);

        Permission::create(['name' => 'ACCEDER_ROLES']);
        Permission::create(['name' => 'VER_ROLES']);
        Permission::create(['name' => 'CREAR_ROLES']);
        Permission::create(['name' => 'MODIFICAR_ROLES']);
        Permission::create(['name' => 'ELIMINAR_ROLES']);

        Permission::create(['name' => 'ACCEDER_PERMISOS']);
        Permission::create(['name' => 'VER_PERMISOS']);
        Permission::create(['name' => 'CREAR_PERMISOS']);
        Permission::create(['name' => 'MODIFICAR_PERMISOS']);
        Permission::create(['name' => 'ELIMINAR_PERMISOS']);

        Permission::create(['name' => 'ACCEDER_LINEAMIENTOS']);
        Permission::create(['name' => 'VER_LINEAMIENTOS']);
        Permission::create(['name' => 'CREAR_LINEAMIENTOS']);
        Permission::create(['name' => 'MODIFICAR_LINEAMIENTOS']);
        Permission::create(['name' => 'ELIMINAR_LINEAMIENTOS']);

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
        //permisos tipo documento
        Permission::create(['name' => 'ACCEDER_TIPO_DOCUMENTO']);
        Permission::create(['name' => 'VER_TIPO_DOCUMENTO']);
        Permission::create(['name' => 'ELIMINAR_TIPO_DOCUMENTO']);
        Permission::create(['name' => 'CREAR_TIPO_DOCUMENTO']);
        Permission::create(['name' => 'MODIFICAR_TIPO_DOCUMENTO']);
        //permisos caracteristicas
        Permission::create(['name' => 'VER_CARACTERISTICAS']);
        Permission::create(['name' => 'CREAR_CARACTERISTICAS']);
        Permission::create(['name' => 'MODIFICAR_CARACTERISTICAS']);
        Permission::create(['name' => 'ELIMINAR_CARACTERISTICAS']);
        //permisos ambitos
        Permission::create(['name' => 'VER_AMBITOS']);
        Permission::create(['name' => 'CREAR_AMBITOS']);
        Permission::create(['name' => 'MODIFICAR_AMBITOS']);
        Permission::create(['name' => 'ELIMINAR_AMBITOS']);

    }
}
