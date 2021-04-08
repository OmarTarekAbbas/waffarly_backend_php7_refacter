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

get_static_routes();
get_dynamic_routes();

// front routes
Route::group(['middleware' => 'front'], function () {
Route::get('/', 'FrontEndController@index')->name('home');
Route::get('home', 'FrontEndController@index')->name('home');
Route::get('category/{id}', 'FrontEndController@products_by_category')->name('category');
Route::get('brand/{id}', 'FrontEndController@get_brand_products')->name('brand');
Route::get('product/{id}', 'FrontEndController@get_product')->name('product');
Route::get('search', 'FrontEndController@search_view')->name('search');
Route::get('search_result', 'FrontEndController@search');
Route::get('terms', 'DuController@terms')->name('terms');
});

// constant
define('Etisalat_Bundle_Route',Etisalat()); // OpID=4
