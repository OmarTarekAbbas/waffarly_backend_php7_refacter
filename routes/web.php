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
Route::get('terms', 'FrontEndController@terms')->name('terms');
});

// constant
define('Etisalat_Bundle_Route',Etisalat()); // OpID=4

// start front routes Etisalat
Route::get('etisalat/newsub', 'EtisalategController@etisalat_newsub');
Route::get(Etisalat_Bundle_Route . "/login_web", 'EtisalategController@login_web');
Route::post(Etisalat_Bundle_Route . '/login_web', 'EtisalategController@validateLogin_web');
Route::get(Etisalat_Bundle_Route . '/subscribe', 'EtisalategController@register2_form');
Route::post(Etisalat_Bundle_Route . '/subscribe', 'EtisalategController@register2');
Route::get(Etisalat_Bundle_Route . "/confirm", 'EtisalategController@confirm_form2');
Route::post(Etisalat_Bundle_Route . "/PinValid", 'EtisalategController@PinValidation2');
Route::get(Etisalat_Bundle_Route . "/dataSubscribe", 'EtisalategController@dataSubscribe');
Route::get(Etisalat_Bundle_Route . "/directSubscribe", 'EtisalategController@directSubscribe');
Route::get("logout_web", 'EtisalategController@logout_web');
// etisalat api url
define('ETISALAT_SYSTEM', 'http://41.33.203.75/~etisalat/etisalat');
define('DEV_SMS_SEND_MESSAGE', 'http://41.33.167.14:2080/~sms/vcode_etisalat_elafasy');
define('ETISALAT_TIBCO_SUBSCRIPTION', 'http://41.33.203.75/~ettibco');

// end front routes Etisalat

// start front routes Etisalat
Route::get('du_landing/{peroid?}/{lang?}', 'DuController@du_landing');
Route::get('du_landing_success', 'DuController@du_landing_success');
Route::get('DuSecureRedirect', 'DuController@DuSecureRedirect');
Route::get('du_unsubc/{peroid?}/{lang?}', 'DuController@du_unsubc');
Route::post('du_unsubcr/{peroid?}/{lang?}', 'DuController@du_unsubcr');
define('DU_UNSUB_SYSTEM', "https://du.notifications.digizone.com.kw/api/unsub");
define('DU_CHECKSUB', "https://du.notifications.digizone.com.kw/api/checkSub");
define('du_operator_id', 9);
Route::get("du_logout_web", 'DuController@logout_web');
// end front routes Etisalat



