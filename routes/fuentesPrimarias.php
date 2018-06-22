<?php
/**
 * Fuentes primarias
 */
Route::resource('datosEncuestas', 'DatosEncuestasController', ['as' => 'fuentesP'])->except([
    'show'
]);;
Route::get('datosEncuestas/data', array('as' => 'fuentesP.datosEncuestas.data', 'uses' => 'DatosEncuestasController@data'));

