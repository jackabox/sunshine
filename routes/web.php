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

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('admin')->group(function () {
    Route::get('licenses', 'Admin\LicenseController@index');
    Route::get('get', 'Api\V1\LicenseController@get');
});

Route::get('documentation', 'DocumentationController@index');
Route::get('documentation/{id}', 'DocumentationController@docs');

Route::prefix('documentation')->group(function () {
});
