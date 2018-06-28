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

Route::resource('establecerPreguntas', 'EstablecerPreguntasController', ['as' => 'fuentesP'])->except([
    'show'
]);;

Route::resource('tipoRespuesta', 'TipoRespuestaController', ['as' => 'fuentesP']);
Route::get('tipoRespuesta/data/data', array('as' => 'fuentesP.tipoRespuesta.data', 'uses' => 'TipoRespuestaController@data'));