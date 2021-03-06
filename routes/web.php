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
// Route::get('/', function () {
//     return view('frontEnd.index');
// });
Auth::routes();

Route::group(['middleware' => ['frontEnd']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/category/{slug}', 'HomeController@category')->name('category');
    Route::get('/product/{slug}', 'HomeController@product')->name('product');

    Route::get('logout','Auth\LoginController@logout');

    Route::group(['prefix' => 'basket'], function () {
        Route::get('/', 'BasketController@index')->name('basket');
    
        Route::post('/create', 'BasketController@create')->name('basket.create');
        Route::delete('/destroy', 'BasketController@destroy')->name('basket.destroy');
        Route::patch('/update/{rowid}', 'BasketController@update')->name('basket.update');
    });

    Route::group(['prefix' => 'wishlist'], function () {
        Route::get('/', 'WishlistController@index')->name('wishlist');
    
        Route::post('/create', 'WishlistController@create')->name('wishlist.create');
        Route::delete('/destroy', 'WishlistController@destroy')->name('wishlist.destroy');
        Route::patch('/update/{rowid}', 'WishlistController@update')->name('wishlist.update');
    });

    Route::group(['prefix' => 'ongkir'], function () {
        Route::get('/', 'OngkirController@index')->name('ongkir');
        Route::get("/loadProvinsi","OngkirController@loadProvinsi")->name('ongkir.loadProvinsi');
        // Route::get("/loadKota","OngkirController@loadKota")->name('ongkir.loadKota');
        Route::get("/loadCityByIdProv/{id}","OngkirController@loadCityByIdProv")->name('ongkir.loadCityByIdProv');

        Route::get("/cekOngkir/{asal}/{kab}/{kurir}/{berat}","OngkirController@cekOngkir")->name('ongkir.cekOngkir');
        Route::get("/addOngkirToDb/{ongkir}","OngkirController@addOngkirToDb")->name('ongkir.addOngkirToDb');
    
        Route::post('/create', 'OngkirController@create')->name('ongkir.create');
        Route::delete('/destroy', 'OngkirController@destroy')->name('ongkir.destroy');
        Route::patch('/update/{rowid}', 'OngkirController@update')->name('ongkir.update');
    });

    Route::get('/payment', 'PaymentController@index')->name('payment');
    Route::post('/dopay', 'PaymentController@handleonlinepay')->name('dopay');
    Route::post('/successful', 'PaymentController@pay')->name('pay');

    Route::get('/orders', 'OrderController@index')->name('orders');
    Route::get('/orders/{id}', 'OrderController@detail')->name('order');

    Route::resource('profile', 'UserDetailController');
});
Route::get('/contact', 'HomeController@contact')->name('contact');

// Route::get('/login', function () {
//     return view('frontEnd.login');
// });

// Route::get('/reg', function () {
//     return view('frontEnd.register');
// });

// Route::get('/category/{slug}', 'HomeController@category')->name('category');
// Route::get('/product/{slug}', 'HomeController@product')->name('product');
// Route::get('/product', function () {
//     return view('frontEnd.product');
// });

// Route::get('/details', function () {
//     return view('frontEnd.details');
// });

// Route::get('/contact', function () {
//     return view('frontEnd.contact');
// });

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

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::match(['get', 'post'], '/admin','AdminController@getLogin')->middleware('guest');
Route::match(['get', 'post'], '/admin/postlogin','AdminController@login');

Route::group(['middleware' => ['adminlogin', 'auth:admin']], function () {
    Route::get('/admin/dashboard','AdminController@dashboard');
    Route::group(["namespace" => "Admin"], function (){
        Route::resource("/admin-users","UsersController");
        Route::get("admin/user/load","UsersController@loadData")->name('admin.user');

        Route::resource("/admin-brand","BrandController");
        Route::get("admin/brand/load","BrandController@loadData")->name('admin.brand');

        Route::resource("/admin-category","CategoryController");
        Route::get("admin/category/load","CategoryController@loadData")->name('admin.category');

        Route::resource("/admin-products","ProductController");
        Route::get("admin/product/load","ProductController@loadData")->name('admin.product');
    });
    Route::get('/admin/logout','AdminController@logout');
});