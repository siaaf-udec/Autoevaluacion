<?php
/**
 * Fuentes Secundarias
 */
// DB::listen(function($query){
// 	echo "<pre>{$query->sql}</pre>";
// });
use Illuminate\Support\Facades\Storage;
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

Route::resource('documentoinstitucional', 'DocumentoInstitucionalController', ['as' => 'documental'])->except([
    'show'
]);
Route::get('documentoinstitucional/data', 
array('as' => 'documental.documentoinstitucional.data', 'uses' => 'DocumentoInstitucionalController@data'));

Route::get('download/{archivo}', function ($archivo) {
    $public_path = public_path();
    $url = $public_path.'/storage/DocumentosInstitucionales/'.$archivo;
    if (Storage::exists($archivo))
    {
      return response()->download($url);
    }
});