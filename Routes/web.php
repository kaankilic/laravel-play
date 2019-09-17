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

Route::prefix('install')->as('laravelplay::')->group(function() {
	Route::get('/', 'LaravelPlayController@index')->name("home");
	Route::get('/verification', 'VerificationController@index')->name("verification");
	Route::post('/verification', 'VerificationController@check');
	Route::get('/database', 'DatabaseController@index')->name("database");
	Route::post('/database', 'DatabaseController@check');
	Route::get('/settings', 'SettingsController@index')->name("settings");
	Route::post('/settings', 'SettingsController@check');
	Route::get('/user', 'UserController@index')->name("user");
	Route::post('/user', 'UserController@create');
});
