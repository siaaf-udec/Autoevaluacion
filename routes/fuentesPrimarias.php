<?php
/**
 * Fuentes primarias
 */
Route::resource('datosEncuestas', 'DatosEncuestasController', ['as' => 'fuentesP'])->except([
    'show', 'destroy'
]);;
Route::get('datosEncuestas/data', array('as' => 'fuentesP.datosEncuestas.data', 'uses' => 'DatosEncuestasController@data'));
Route::delete('usuarios/destroy/{id?}', [
                'uses' => 'DatosEncuestasController@destroy',
                'as' => 'admin.usuarios.destroy'
])->where(['id' => '[0-9]+']);


Route::resource('data', 'DatosEncuestasController');