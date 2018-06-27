<?php
/**
 * Super administrador
 */

//  DB::listen(function ($query) {
//     DB::connection()->enableQueryLog();
//  });

Route::get('/', array('as' => 'admin.home', 'uses' => 'pageController@index'));

Route::resource('usuarios', 'userController', ['as' => 'admin'])->except([
    'show'
]);
Route::get('usuarios/data', array('as' => 'admin.usuarios.data', 'uses' => 'userController@data'));

Route::resource('roles', 'RolController', ['as' => 'admin'])->except([
    'show'
]);
Route::get('roles/data', array('as' => 'admin.roles.data', 'uses' => 'RolController@data'));

Route::resource('permisos', 'PermisosController', ['as' => 'admin'])->except([
    'show'
]);
Route::get('permisos/data', array('as' => 'admin.permisos.data', 'uses' => 'PermisosController@data'));


Route::resource('lineamientos', 'LineamientoController', ['as' => 'admin'])->except([
    'show'
]);
Route::get('lineamientos/data/data', array('as' => 'admin.lineamientos.data', 'uses' => 'LineamientoController@data'));



Route::resource('factores', 'FactorController', ['as' => 'admin']);

Route::get('factores/data/data', array('as' => 'admin.factores.data', 'uses' => 'FactorController@data'));


Route::resource('caracteristicas', 'CaracteristicasController', ['as' => 'admin']);

Route::get(
    'caracteristicas/data/data',
array('as' => 'admin.caracteristicas.data', 'uses' => 'CaracteristicasController@data')
);

Route::get('caracteristicas/factor/{id}', 'CaracteristicasController@factores');

Route::resource('ambito', 'AmbitoController', ['as' => 'admin'])->except([
    'show']);

Route::get(
    'ambito/data',
array('as' => 'admin.ambito.data', 'uses' => 'AmbitoController@data')
);


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

Route::resource('procesos', 'ProcesosController', ['as' => 'admin']);