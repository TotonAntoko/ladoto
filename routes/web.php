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

// CUSTOMER
Route::get('/admin/customer/', 'CustomerController@index');
Route::post('/admin/customer/create', 'CustomerController@create');
Route::put('/admin/customer/update', 'CustomerController@update');
Route::delete('/admin/customer/delete', 'CustomerController@destroy');

// INVENTORY
Route::get('/admin/inventory/', 'InventoryController@index');
Route::post('/admin/inventory/create', 'InventoryController@create');
Route::put('/admin/inventory/update', 'InventoryController@update');
Route::delete('/admin/inventory/delete', 'InventoryController@destroy');

Route::get('/admin/brand', function () {
    return view ('/admin/brand');
});