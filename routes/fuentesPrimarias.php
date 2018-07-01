<?php
/**
 * Fuentes primarias
 */
Route::resource('datosEncuestas', 'DatosEncuestasController', ['as' => 'fuentesP'])->except(['show']);

Route::get('datosEncuestas/data', array('as' => 'fuentesP.datosEncuestas.data', 'uses' => 'DatosEncuestasController@data'));

Route::resource('datosEspecificos', 'DatosEspecificosController', ['as' => 'fuentesP'])->except([
    'show'
]);

Route::get('datosEspecificos/data', array('as' => 'fuentesP.datosEspecificos.data', 'uses' => 'DatosEspecificosController@data'));

Route::resource('encuestas', 'EncuestasController', ['as' => 'fuentesP']);

Route::resource('establecerPreguntas', 'EstablecerPreguntasController', ['as' => 'fuentesP'])->except([
    'show'
]);

Route::resource('tipoRespuesta', 'TipoRespuestaController', ['as' => 'fuentesP']);
Route::get('tipoRespuesta/data/data', array('as' => 'fuentesP.tipoRespuesta.data', 'uses' => 'TipoRespuestaController@data'));


Route::resource('ponderacionRespuesta', 'PonderacionRespuestasController', ['as' => 'fuentesP']);

Route::get('ponderacion/{id}', array('as' => 'fuentesP.ponderacionRespuesta.datos', 'uses' => 'PonderacionRespuestasController@create'));

Route::get('ponderacionRespuesta/data/data', array('as' => 'fuentesP.ponderacionRespuesta.data', 'uses' => 'PonderacionRespuestasController@data'));

//preguntas
Route::resource('preguntas', 'PreguntasController', ['as' => 'fuentesP']);
Route::get('preguntas/data/data', array('as' => 'fuentesP.preguntas.data', 'uses' => 'PreguntasController@data'));

//Importar preguntas
Route::resource('Importarpreguntas', 'ImportarPreguntasController', ['as' => 'fuentesP']);

//respuestas
Route::get('respuestas/{id}', array('as' => 'fuentesP.respuestas.datos', 'uses' => 'RespuestasController@create'));
Route::get('respuestas/data/data', array('as' => 'fuentesP.respuestas.data', 'uses' => 'RespuestasController@data'));

