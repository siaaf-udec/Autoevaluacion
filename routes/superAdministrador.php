<?php
/**
 * Super administrador
 */
Route::get('/', array('as' => 'admin.home', 'uses' => 'pageController@index'));

Route::resource('usuarios', 'userController', ['as' => 'admin'])->except([
    'show'
]);
Route::get('usuarios/data', array('as' => 'admin.usuarios.data', 'uses' => 'userController@data'));

Route::resource('rol', 'RolController', ['as' => 'admin'])->except([
    'show'
]);
Route::get('roles/data', array('as' => 'admin.rol.data', 'uses' => 'RolController@data'));
