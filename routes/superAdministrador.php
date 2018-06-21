<?php
/**
 * Super administrador
 */
Route::get('/', array('as' => 'admin.home', 'uses' => 'pageController@index'));

Route::resource('usuarios', 'userController', ['as' => 'admin'])->except([
    'show', 'destroy'
]);;
Route::get('usuarios/data', array('as' => 'admin.usuarios.data', 'uses' => 'userController@data'));
Route::delete('usuarios/destroy/{id?}', [
                'uses' => 'userController@destroy',
                'as' => 'admin.usuarios.destroy'
])->where(['id' => '[0-9]+']);


Route::resource('data', 'UserController');