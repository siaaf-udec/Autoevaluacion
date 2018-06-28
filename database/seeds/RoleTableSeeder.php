<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Crear rol y asignar permisos superadmin
        $role = Role::create(['name' => 'SUPERADMIN']);
        $role->givePermissionTo(Permission::all());
        
        //Crear y asignar permisos fuentes primarias
        $role = Role::create(['name' => 'FUENTES_PRIMARIAS']);

        $role->givePermissionTo([
            'VER_ENCUESTAS',
            'CREAR_ENCUESTAS',
            'MODIFICAR_ENCUESTAS',
            'ELIMINAR_ENCUESTAS',
            'VER_DATOS',
            'MODIFICAR_DATOS',
            'ELIMINAR_DATOS',
            'CREAR_DATOS',
            'ACCEDER_TIPO_RESPUESTAS',
            'VER_TIPO_RESPUESTAS',
            'MODIFICAR_TIPO_RESPUESTAS',
            'ELIMINAR_TIPO_RESPUESTAS',
            'CREAR_TIPO_RESPUESTAS',
        ]);

        //Crear y asignar permisos fuentes secundarias
        $role = Role::create(['name' => 'FUENTES_SECUNDARIAS']);
        $role->givePermissionTo([
            'VER_DEPENDENCIAS',
            'CREAR_DEPENDENCIAS',
            'MODIFICAR_DEPENDENCIAS',
            'ELIMINAR_DEPENDENCIAS',
            'VER_GRUPO_DOCUMENTOS',
            'CREAR_GRUPO_DOCUMENTOS',
            'MODIFICAR_GRUPO_DOCUMENTOS',
            'ELIMINAR_GRUPO_DOCUMENTOS',
            'ACCEDER_TIPO_DOCUMENTO',
            'VER_TIPO_DOCUMENTO',
            'CREAR_TIPO_DOCUMENTO',
            'MODIFICAR_TIPO_DOCUMENTO',
            'ELIMINAR_TIPO_DOCUMENTO',
            'ACCEDER_INDICADORES_DOCUMENTALES',
            'VER_INDICADORES_DOCUMENTALES',
            'CREAR_INDICADORES_DOCUMENTALES',
            'MODIFICAR_INDICADORES_DOCUMENTALES',
            'ELIMINAR_INDICADORES_DOCUMENTALES',
        ]);
    }
}
