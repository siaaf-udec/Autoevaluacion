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

 // Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.in');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');


/*
// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
*/
// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.res');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');



Route::get('/home', function () {
    return view('admin.layouts.app');
})->name('admin.home');

Route::get('/', function () {
    return view('public.layouts.index');
})->name('home');
Route::get('/direccion', function () {
    return view('public.layouts.direccion');
})->name('direccion');
Route::get('/sistema', function () {
    return view('public.layouts.sistema');
})->name('sistema');
