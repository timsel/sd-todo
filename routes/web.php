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

Route::get('/tasks', 'TaskController@index');
Route::post('/task', 'TaskController@create');
Route::post('/task/{task}', 'TaskController@modify');
Route::get('/task/{task}', 'TaskController@load');
Route::delete('/task/{task}', 'TaskController@delete');
Route::post('/task/toggle/{task}', 'TaskController@toggle');

/**
 * Simple indexcontroller
 */
Route::get('/', function () {
    return view('index');
});

Auth::routes();
