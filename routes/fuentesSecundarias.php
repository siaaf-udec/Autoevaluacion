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
Route::get(
    'dependencia/data',
array('as' => 'documental.dependencia.data', 'uses' => 'DependenciaController@data')
);

Route::resource('grupodocumentos', 'DocumentGroupController', ['as' => 'documental'])->except([
    'show', 'edit'
]);;
Route::get(
    'grupodocumentos/data',
array('as' => 'documental.grupodocumentos.data', 'uses' => 'DocumentGroupController@data')
);

Route::resource('tipodocumento', 'tipoDocumentoController', ['as' => 'documental'])->except([
    'show', 'edit'
]);
Route::get(
    'fuentes/tipodocumento/data',
array('as' => 'documental.tipodocumento.data', 'uses' => 'tipoDocumentoController@data')
);

Route::resource('documentoinstitucional', 'DocumentoInstitucionalController', ['as' => 'documental'])->except([
    'show'
]);
Route::get(
    'documentoinstitucional/data',
array('as' => 'documental.documentoinstitucional.data', 'uses' => 'DocumentoInstitucionalController@data')
);


Route::resource('indicadores_documentales', 'IndicadorDocumentalController', ['as' => 'documental']);
Route::get(
    'indicadores_documentales/data/data',
array('as' => 'documental.indicadores_documentales.data', 'uses' => 'IndicadorDocumentalController@data')
);

Route::resource('documentos_autoevaluacion', 'DocumentoAutoevaluacionController', ['as' => 'documental']);
Route::get(
    'documentos_autoevaluacion/data/data',
array('as' => 'documental.documentos_autoevaluacion.data', 'uses' => 'DocumentoAutoevaluacionController@data')
);
Route::get(
    'documentos_autoevaluacion/caracteristicas/{id}',
array('as' => 'documental.documentos_autoevaluacion.caracteristicas',
'uses' => 'DocumentoAutoevaluacionController@obtenerCaracteristicas')
);

Route::get('informes_documentales', array(
    'as' => 'documental.informe_documental',
    'uses' => 'ReporteController@index'
));

Route::get('informes_documentales/datos', array(
    'as' => 'documental.informe_documental.datos',
    'uses' => 'ReporteController@obtenerDatos'
));

Route::post('informes_documentales/filtrar', array(
    'as' => 'documental.informe_documental.filtrar',
    'uses' => 'ReporteController@filtro'
));

Route::get('informes_documentales/institucional', array(
    'as' => 'documental.informe_documental.institucional',
    'uses' => 'ReporteController@reportes'
));
Route::get('informes_documentales/data', array(
    'as' => 'documental.informe_documental.data',
    'uses' => 'ReporteController@obtenerDatosInst'
));
Route::get('informes_documentales/pdf', array(
    'as' => 'documental.informe_documental.pdf',
    'uses' => 'ReporteController@pdf'
));
