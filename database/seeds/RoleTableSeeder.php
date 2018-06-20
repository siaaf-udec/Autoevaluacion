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
            'ELIMINAR_ENCUESTAS'
        ]);

        //Crear y asignar permisos fuentes secundarias
        $role = Role::create(['name' => 'FUENTES_SECUNDARIAS']);
        $role->givePermissionTo([
            'VER_DEPENDENCIAS',
            'CREAR_DEPENDENCIAS',
            'MODIFICAR_DEPENDENCIAS',
            'ELIMINAR_DEPENDENCIAS'
        ]);
    }
}
