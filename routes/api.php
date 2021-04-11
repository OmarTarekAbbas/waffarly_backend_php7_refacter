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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('etisalat/notification', 'EtisalategController@etisalat_notification');
Route::post('etisalat/notification_rest', 'EtisalategController@notification_rest');
Route::post('charging_response_simulate', 'EtisalategController@charging_response_simulate');
Route::get('charging', 'EtisalategController@charging');
Route::get('etisalat_daily_charging', 'EtisalategController@etisalat_daily_charging');
Route::get('etisalat_yesterday_final_failed', 'EtisalategController@etisalat_yesterday_final_failed');
define('grace_days_100', 100);
