<?php
/**
 * Super administrador
 */
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
Route::get('lineamientos/data', array('as' => 'admin.lineamientos.data', 'uses' => 'LineamientoController@data'));



Route::resource('factores', 'FactorController', ['as' => 'admin'])->except([
    'show'
]);;

Route::get('factores/data', array('as' => 'admin.factores.data', 'uses' => 'FactorController@data'));


Route::resource('caracteristicas', 'CaracteristicasController', ['as' => 'admin'])->except([
    'show']);

Route::get('caracteristicas/data', 
array('as' => 'admin.caracteristicas.data', 'uses' => 'CaracteristicasController@data'));

Route::get('caracteristicas/factor/{id}','CaracteristicasController@factores');

Route::resource('ambito', 'AmbitoController', ['as' => 'admin'])->except([
    'show']);

Route::get('ambito/data', 
array('as' => 'admin.ambito.data', 'uses' => 'AmbitoController@data'));