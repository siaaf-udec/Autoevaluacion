<?php
/**
 * Fuentes Secundarias
 */
// DB::listen(function($query){
// 	echo "<pre>{$query->sql}</pre>";
// });

Route::resource('dependencia', 'DependenciaController', ['as' => 'documental'])->except([
    'show', 'edit'
]);;
Route::get('dependencia/data', 
array('as' => 'documental.dependencia.data', 'uses' => 'DependenciaController@data'));

Route::resource('grupodocumentos', 'DocumentGroupController', ['as' => 'documental'])->except([
    'show', 'edit'
]);;
Route::get('grupodocumentos/data', 
array('as' => 'documental.grupodocumentos.data', 'uses' => 'DocumentGroupController@data'));

Route::resource('tipodocumento', 'tipoDocumentoController', ['as' => 'documental'])->except([
    'show', 'edit'
]);
Route::get('fuentes/tipodocumento/data', 
array('as' => 'documental.tipodocumento.data', 'uses' => 'tipoDocumentoController@data'));