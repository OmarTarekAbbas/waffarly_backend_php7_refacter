<?php 
 /*Generated Route File @iVAS*/ 
 Mail : karimahmed181@gmail.com 
 
/*
|--------------------------------------------------------------------------

| Application Routes

|--------------------------------------------------------------------------

|

| Here is where you can register all of the routes for an application.

| It's a breeze. Simply tell Laravel the URIs it should respond to

| and give it the controller to call when that URI is requested.

|
*/
 
Route::group(['middleware'=>['auth','role:super_admin|admin']], function () {
Route::get('post','PostController@index');
Route::get('post/create','PostController@create');
Route::post('post','PostController@store');
Route::get('post/{id}','PostController@show');
Route::get('post/{id}/edit','PostController@edit');
Route::patch('post/{id}','PostController@update');
Route::get('post/{id}/delete','PostController@destroy');
Route::get('sub_category','SubCategoryController@index');
Route::get('sub_category/create','SubCategoryController@create');
Route::post('sub_category','SubCategoryController@store');
Route::get('sub_category/{id}','SubCategoryController@show');
Route::get('sub_category/{id}/edit','SubCategoryController@edit');
Route::patch('sub_category/{id}','SubCategoryController@update');
Route::get('sub_category/{id}/delete','SubCategoryController@destroy');
Route::get('rbt','RbtController@index');
Route::get('rbt/create','RbtController@create');
Route::post('rbt','RbtController@store');
Route::get('rbt/{id}','RbtController@show');
Route::get('rbt/{id}/edit','RbtController@edit');
Route::patch('rbt/{id}','RbtController@update');
Route::get('rbt/{id}/delete','RbtController@destroy');
Route::get('content','ContentController@index');
Route::get('content/create','ContentController@create');
Route::post('content','ContentController@store');
Route::get('content/{id}','ContentController@show');
Route::get('content/{id}/edit','ContentController@edit');
Route::patch('content/{id}','ContentController@update');
Route::get('content/{id}/delete','ContentController@destroy');
Route::get('category','CategoryController@index');
Route::get('category/create','CategoryController@create');
Route::post('category','CategoryController@store');
Route::get('category/{id}','CategoryController@show');
Route::get('category/{id}/edit','CategoryController@edit');
Route::patch('category/{id}','CategoryController@update');
Route::get('category/{id}/delete','CategoryController@destroy');
Route::get('content_type','ContentTypeController@index');
Route::get('content_type/create','ContentTypeController@create');
Route::post('content_type','ContentTypeController@store');
Route::get('content_type/{id}','ContentTypeController@show');
Route::get('content_type/{id}/edit','ContentTypeController@edit');
Route::patch('content_type/{id}','ContentTypeController@update');
Route::get('content_type/{id}/delete','ContentTypeController@destroy');
Route::get('provider','ProviderController@index');
Route::get('provider/create','ProviderController@create');
});
 
Route::group(['middleware'=>['auth','role:super_admin']], function () {
Route::get('country','CountryController@index');
Route::get('country/create','CountryController@create');
Route::post('country','CountryController@store');
Route::get('country/{id}','CountryController@show');
Route::get('country/{id}/edit','CountryController@edit');
Route::patch('country/{id}','CountryController@update');
Route::get('country/{id}/delete','CountryController@delete');
Route::get('dashboard','DashboardController@index');
Route::get('file_manager','DashboardController@file_manager');
Route::get('upload_items','DashboardController@multi_upload');
Route::post('save_items','DashboardController@save_uploaded');
Route::get('upload_resize','DashboardController@upload_resize');
Route::get('upload_resize_v2','DashboardController@upload_resize_v2');
Route::post('save_image','DashboardController@save_image');
Route::get('delete_all','DashboardController@delete_all_index');
Route::post('delete_all','DashboardController@delete_all_store');
Route::get('migrate_tables','DashboardController@migrate_tables');
Route::get('language','LanguageController@index');
Route::get('language/create','LanguageController@create');
Route::post('language','LanguageController@store');
Route::get('language/{id}/edit','LanguageController@edit');
Route::post('language/{id}/update','LanguageController@update');
Route::get('language/{id}/delete','LanguageController@destroy');
Route::get('operator','OperatorController@index');
Route::get('operator/create','OperatorController@create');
Route::post('operator','OperatorController@store');
Route::get('operator/{id}','OperatorController@show');
Route::get('operator/{id}/edit','OperatorController@edit');
Route::patch('operator/{id}','OperatorController@update');
Route::get('operator/{id}/delete','OperatorController@destroy');
Route::post('provider','ProviderController@store');
Route::get('provider/{id}','ProviderController@show');
Route::get('provider/{id}/edit','ProviderController@edit');
Route::patch('provider/{id}','ProviderController@update');
Route::get('provider/{id}/delete','ProviderController@destroy');
Route::get('roles','RoleController@index');
Route::get('roles/new','RoleController@create');
Route::post('roles','RoleController@store');
Route::get('roles/{id}/edit','RoleController@edit');
Route::post('roles/{id}/update','RoleController@update');
Route::get('roles/{id}/delete','RoleController@destroy');
Route::get('roles/{id}/view_access','RoleController@view_access');
Route::get('all_routes','RouteController@index');
Route::get('routes/create','RouteController@create');
Route::post('routes','RouteController@store');
Route::get('routes/index_v2','RouteController@index_v2');
Route::get('routes/{id}/edit','RouteController@edit');
Route::post('routes/{id}/update','RouteController@update');
Route::get('routes/{id}/delete','RouteController@destroy');
Route::get('setting','SettingController@index');
Route::get('setting/new','SettingController@create');
Route::post('setting','SettingController@store');
Route::get('setting/{id}/edit','SettingController@edit');
Route::post('setting/{id}','SettingController@update');
Route::get('setting/{id}/delete','SettingController@destroy');
Route::post('sortabledatatable','SettingController@updateOrder');
Route::get('static_translation','StaticTranslationController@index');
Route::post('static_translation/{id}/update','StaticTranslationController@update');
Route::get('static_translation/{id}/delete','StaticTranslationController@destroy');
Route::get('types/index','TypeController@index');
Route::get('types/create','TypeController@create');
Route::post('types','TypeController@store');
Route::get('types/{id}/edit','TypeController@edit');
Route::patch('types/{id}','TypeController@update');
Route::get('types/{id}/delete','TypeController@destroy');
Route::get('users','UserController@index');
Route::get('users/new','UserController@create');
Route::post('users','UserController@store');
Route::get('users/{id}/edit','UserController@edit');
Route::post('users/{id}/update','UserController@update');
Route::get('users/{id}/delete','UserController@destroy');
Route::get('user_profile','UserController@profile');
Route::post('user_profile/updatepassword','UserController@UpdatePassword');
Route::post('user_profile/updateprofilepic','UserController@UpdateProfilePicture');
Route::post('user_profile/updateuserdata','UserController@UpdateNameAndEmail');
});
 

Route::get('/','DashboardController@index');
Route::get('buildroutes','RouteController@buildroutes');
Route::post('sortabledatatable','UserController@updateOrder');
