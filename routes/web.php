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

Route::get('/admin/', function () {
    return view ('admin.index');
});

Route::get('/admin/pelanggan/', function () {
    return view ('admin.pelanggan');
});

Route::get('/admin/inventory', function () {
    return view ('admin.inventory');
});

Route::get('/admin/brand', function () {
    return view ('/admin/brand');
});