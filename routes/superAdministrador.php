<?php
/**
 * Super administrador
 */
Route::get('/', array('as' => 'admin.home', 'uses' => 'pageController@index'));

Route::resource('usuarios', 'userController', ['as' => 'admin'])->except([
    'show'
]);
Route::get('usuarios/data', array('as' => 'admin.usuarios.data', 'uses' => 'userController@data'));