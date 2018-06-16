<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::group(['prefix' => 'admin/lira'], function () {
    Route::get('/', function () {
        return view('admin.layouts.app');
    });
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::group(['prefix' => 'superAdministrador'], function () {
    });
    Route::group(['prefix' => 'fuentesPrimarias'], function () {
    });
    Route::group(['prefix' => 'fuentesSecundarias'], function () {
    });
});
