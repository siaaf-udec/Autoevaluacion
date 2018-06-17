<?php
/**
 * Super administrador
 */

Route::get('/', function () {
    return view('admin.layouts.app');
})->name('admin.home');
