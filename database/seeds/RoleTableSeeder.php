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
            'ACCEDER_ENCUESTAS',
            'VER_ENCUESTAS',
            'CREAR_ENCUESTAS',
            'MODIFICAR_ENCUESTAS',
            'ELIMINAR_ENCUESTAS',
            'ACCEDER_DATOS',
            'VER_DATOS',
            'MODIFICAR_DATOS',
            'ELIMINAR_DATOS',
            'CREAR_DATOS',
            'ACCEDER_ESTABLECER_PREGUNTAS',
            'VER_ESTABLECER_PREGUNTAS',
            'MODIFICAR_ESTABLECER_PREGUNTAS',
            'ELIMINAR_ESTABLECER_PREGUNTAS',
            'CREAR_ESTABLECER_PREGUNTAS',
            'ACCEDER_TIPO_RESPUESTAS',
            'VER_TIPO_RESPUESTAS',
            'MODIFICAR_TIPO_RESPUESTAS',
            'ELIMINAR_TIPO_RESPUESTAS',
            'CREAR_TIPO_RESPUESTAS',
            'ACCEDER_PONDERACION_RESPUESTAS',
            'VER_PONDERACION_RESPUESTAS',
            'MODIFICAR_PONDERACION_RESPUESTAS',
            'ELIMINAR_PONDERACION_RESPUESTAS',
            'CREAR_PONDERACION_RESPUESTAS',
            'ACCEDER_PREGUNTAS',
            'VER_PREGUNTAS',
            'MODIFICAR_PREGUNTAS',
            'ELIMINAR_PREGUNTAS',
            'CREAR_PREGUNTAS',
            'ACCEDER_RESPUESTAS',
            'VER_RESPUESTAS',
            'MODIFICAR_RESPUESTAS',
            'ELIMINAR_RESPUESTAS',
            'CREAR_RESPUESTAS',
        ]);

        //Crear y asignar permisos fuentes secundarias
        $role = Role::create(['name' => 'FUENTES_SECUNDARIAS']);
        $role->givePermissionTo([
            'ACCEDER_DEPENDENCIAS',
            'VER_DEPENDENCIAS',
            'CREAR_DEPENDENCIAS',
            'MODIFICAR_DEPENDENCIAS',
            'ELIMINAR_DEPENDENCIAS',
            'ACCEDER_GRUPO_DOCUMENTOS',
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
            'ACCEDER_DOCUMENTOS_AUTOEVALUACION',
            'VER_DOCUMENTOS_AUTOEVALUACION',
            'CREAR_DOCUMENTOS_AUTOEVALUACION',
            'MODIFICAR_DOCUMENTOS_AUTOEVALUACION',
            'ELIMINAR_DOCUMENTOS_AUTOEVALUACION',
            'ACCEDER_DOCUMENTOS_INSTITUCIONALES',
            'VER_DOCUMENTOS_INSTITUCIONALES',
            'CREAR_DOCUMENTOS_INSTITUCIONALES',
            'MODIFICAR_DOCUMENTOS_INSTITUCIONALES',
            'ELIMINAR_DOCUMENTOS_INSTITUCIONALES',
        ]);
    }
}
