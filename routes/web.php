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
    return view('bankwide');
});

Route::get('/bankwide', function () {
    return view('bankwide');
});

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/state', function () {
    return view('state');
});

Route::get('/branches', function () {
    return view('branches');
});

Route::get('/form', function () {
    return view('form');
});

Route::post('/import_tb', 'Controller@tb');
Route::post('/import_sb', 'Controller@sb');
Route::post('/export', 'Controller@export');
