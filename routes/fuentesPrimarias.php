<?php
/**
 * Fuentes primarias
 */
Route::resource('datosEncuestas', 'DatosEncuestasController', ['as' => 'fuentesP'])->except(['show']);;

Route::get('datosEncuestas/data', array('as' => 'fuentesP.datosEncuestas.data', 'uses' => 'DatosEncuestasController@data'));

Route::resource('datosEspecificos', 'DatosEspecificosController', ['as' => 'fuentesP'])->except([
    'show'
]);;

Route::get('datosEspecificos/data', array('as' => 'fuentesP.datosEspecificos.data', 'uses' => 'DatosEspecificosController@data'));

Route::resource('encuestas', 'EncuestasController', ['as' => 'fuentesP']);