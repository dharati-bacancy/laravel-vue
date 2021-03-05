<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

//Api for getting count of widgets
Route::get('/widgets', 'Api\DashboardController@widgets');

//Resource Api's
Route::prefix('resource')->group(function () {
    Route::get('index', 'Api\ResourceController@index');
    Route::post('store', 'Api\ResourceController@store');
    Route::get('edit/{id}', 'Api\ResourceController@edit');
    Route::post('update', 'Api\ResourceController@update');
    Route::post('delete', 'Api\ResourceController@destroy');
});

