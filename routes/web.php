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
/**
 * Customer routes
 */
Route::get('/', function () {
    return view('frontEnd.index');
});

// Route::get('/login', function () {
//     return view('frontEnd.login');
// });

// Route::get('/reg', function () {
//     return view('frontEnd.register');
// });

Route::get('/product', function () {
    return view('frontEnd.product');
});

Route::get('/details', function () {
    return view('frontEnd.details');
});

Route::get('/contact', function () {
    return view('frontEnd.contact');
});


/**
 * Admin routes
 */
// Route::namespace('Admin')->group(function () {
//     Route::get('admin/login', 'LoginController@showLoginForm')->name('admin.login');
//     Route::post('admin/login', 'LoginController@login')->name('admin.login');
//     Route::get('admin/logout', 'LoginController@logout')->name('admin.logout');
// });
// Route::group(['prefix' => 'admin', 'middleware' => ['employee'], 'as' => 'admin.' ], function () {
//     Route::namespace('Admin')->group(function () {
//         Route::get('/', 'DashboardController@index')->name('dashboard');
//     });
// });

// Route::get('/admin/', function () {
//     return view ('admin.index');
// });

// // CUSTOMER
// Route::get('/admin/customer/', 'CustomerController@index');
// Route::post('/admin/customer/create', 'CustomerController@create');
// Route::put('/admin/customer/update', 'CustomerController@update');
// Route::delete('/admin/customer/delete', 'CustomerController@destroy');

// // INVENTORY
// Route::get('/admin/inventory/', 'InventoryController@index');
// Route::post('/admin/inventory/create', 'InventoryController@create');
// Route::put('/admin/inventory/update', 'InventoryController@update');
// Route::delete('/admin/inventory/delete', 'InventoryController@destroy');

// Route::get('/admin/brand', function () {
//     return view ('/admin/brand');
// });
