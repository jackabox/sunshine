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

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('licenses', 'Admin\LicenseController@index');

    Route::resource('products', 'Admin\ProductController', [
        'names' => [
            'index' => 'admin.products.index',
            'create' => 'admin.products.create',
            'edit' => 'admin.products.edit',

        ]
    ]);

    Route::post('github/releases', 'GitHubController@ajaxReleases');
    Route::post('github/release/download', 'GitHubController@ajaxFetchFiles');
});

Route::get('get', 'Api\V1\LicenseController@get');

Route::get('documentation', 'DocumentationController@index');
Route::get('documentation/{id}', 'DocumentationController@docs');

Route::prefix('documentation')->group(function () {
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
