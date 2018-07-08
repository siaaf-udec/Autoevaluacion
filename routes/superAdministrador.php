<?php
/**
 * Super administrador
 */

 //Home
Route::get('/', array('as' => 'admin.home', 'uses' => 'pageController@index'));
//Rutas necesarias para selecionar proceso
Route::get('mostrar_procesos', array('as' => 'admin.mostrar_procesos', 'uses' => 'pageController@mostrarProcesos'));
Route::post('seleccionar_proceso', array('as' => 'admin.mostrar_procesos.seleccionar_proceso', 'uses' => 'pageController@seleccionarProceso'));

//Usuarios
Route::resource('usuarios', 'userController', ['as' => 'admin'])->except([
    'show'
]);
Route::get('usuarios/data', array('as' => 'admin.usuarios.data', 'uses' => 'userController@data'));

//Roles
Route::resource('roles', 'RolController', ['as' => 'admin'])->except([
    'show'
]);
Route::get('roles/data', array('as' => 'admin.roles.data', 'uses' => 'RolController@data'));

//Permisos
Route::resource('permisos', 'PermisosController', ['as' => 'admin'])->except([
    'show'
]);
Route::get('permisos/data', array('as' => 'admin.permisos.data', 'uses' => 'PermisosController@data'));

//Lineamientos
Route::resource('lineamientos', 'LineamientoController', ['as' => 'admin'])->except([
    'show'
]);
Route::get('lineamientos/data/data', array('as' => 'admin.lineamientos.data', 'uses' => 'LineamientoController@data'));

//Factores
Route::resource('factores', 'FactorController', ['as' => 'admin']);
Route::get('factores/data/data', array('as' => 'admin.factores.data', 'uses' => 'FactorController@data'));

//Caracateristicas
Route::resource('caracteristicas', 'CaracteristicasController', ['as' => 'admin']);
Route::get(
    'caracteristicas/data/data',
array('as' => 'admin.caracteristicas.data', 'uses' => 'CaracteristicasController@data')
);
Route::get('caracteristicas/factor/{id}', 'CaracteristicasController@factores');

//Ambitos
Route::resource('ambito', 'AmbitoController', ['as' => 'admin'])->except([
    'show']);

Route::get(
    'ambito/data',
array('as' => 'admin.ambito.data', 'uses' => 'AmbitoController@data')
);

//Aspectos
Route::resource('aspectos', 'AspectoController', ['as' => 'admin']);
Route::get('aspectos/data/data', array('as' => 'admin.aspectos.data', 'uses' => 'AspectoController@data'));

//Sedes
Route::resource('sedes', 'SedeController', ['as' => 'admin']);
Route::get('sedes/data/data', array('as' => 'admin.sedes.data', 'uses' => 'SedeController@data'));

//Facultades
Route::resource('facultades', 'FacultadController', ['as' => 'admin']);
Route::get('facultades/data/data', array('as' => 'admin.facultades.data', 'uses' => 'FacultadController@data'));

//Programas académicos
Route::resource('programas_academicos', 'ProgramaAcademicoController', ['as' => 'admin']);
Route::get('programas_academicos/data/data', array('as' => 'admin.programas_academicos.data',
 'uses' => 'ProgramaAcademicoController@data'));

 //Procesos para programas
Route::resource('procesos_programas', 'ProcesoProgramaController', ['as' => 'admin']);
Route::get('procesos_programas/data/data', array(
    'as' => 'admin.procesos_programas.data',
    'uses' => 'ProcesoProgramaController@data'
));
Route::get('procesos_programas/{id_sede}/{id_facultad}', array(
    'as' => 'admin.procesos_programas.obtener_programas',
    'uses' => 'ProcesoProgramaController@ObtenerProgramas'
));

//Grupos de Interes
Route::resource('grupos_interes', 'GruposInteresController', ['as' => 'admin']);
Route::get('grupos_interes/data/data', array('as' => 'admin.grupos_interes.data', 'uses' => 'GruposInteresController@data'));
