<?php
/**
 * Fuentes Secundarias
 */
// DB::listen(function($query){
// 	echo "<pre>{$query->sql}</pre>";
// });
/**
 * Rutas para la opcion de dependencias
 */
Route::get('/', array('as' => 'admin.home', 'uses' => 'pageController@index'));

Route::resource('dependencia', 'DependenciaController', ['as' => 'documental'])->except([
    'show', 'destroy'
]);;
Route::get('dependencia/data', array('as' => 'documental.dependencia.data', 'uses' => 'DependenciaController@data'));
Route::delete('dependencia/destroy/{id?}', [
                'uses' => 'DependenciaController@destroy',
                'as' => 'documental.dependencia.destroy'
])->where(['id' => '[0-9]+']);

Route::resource('data', 'DependenciaController');
/**
 * Fin de rutas dependencia
 */

 /**
 * Rutas para la opcion de grupo de documentos
 */
Route::get('/', array('as' => 'admin.home', 'uses' => 'pageController@index'));

Route::resource('grupodocumentos', 'DocumentGroupController', ['as' => 'documental'])->except([
    'show', 'destroy'
]);;
Route::get('grupodocumentos/data', array('as' => 'documental.grupodocumentos.data', 'uses' => 'DocumentGroupController@data'));
Route::delete('grupodocumentos/destroy/{id?}', [
                'uses' => 'DocumentGroupController@destroy',
                'as' => 'documental.grupodocumentos.destroy'
])->where(['id' => '[0-9]+']);

Route::resource('data', 'DocumentGroupController');
/**
 * Fin de rutas grupo documentos
 */

Route::resource('tipodocumento', 'tipoDocumentoController', ['as' => 'documental'])->except([
    'show', 'edit'
]);
Route::get('fuentes/tipodocumento/data', 
array('as' => 'documental.tipodocumento.data', 'uses' => 'tipoDocumentoController@data'));