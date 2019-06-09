<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(["namespace" => "Admin"], function (){
    Route::post('auth/brand/register', 'BrandController@register')->name('api.brand.register');
    Route::post('auth/brand/login', 'BrandController@login');
    Route::get('auth/brand/showProduct', 'BrandController@allBrand')->middleware('auth:api');
    Route::get('auth/brand/showProduct/{id}', 'BrandController@allBrandById')->middleware('auth:api');

    Route::get('product', 'ProductController@products')->middleware('auth:api');
    Route::post('product/add', 'ProductController@add')->middleware('auth:api');
    Route::put('product/{product}', 'ProductController@updateApi')->middleware('auth:api');
    Route::delete('product/{product}', 'ProductController@deleteApi')->middleware('auth:api');
});
