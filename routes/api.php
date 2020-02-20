<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/* splash
params:
1."app_version" -> versi aplikasi pada hp
2."token" -> token bila ada
*/
Route::post('splash', 'SplashController@splash');

/* login
params:
1."phone_number" -> account phone number
2."pin" -> account pin (6 digit)
*/
Route::post('login', 'UserController@login');

/* register
nb: dibuat untuk membuat akun baru guna membantu proses uji coba
*/

Route::post('register', 'UserController@register');

/* Middleware */
Route::group(['middleware' => 'auth:api'], function () {

    //testing
    Route::post('tes', 'TestController@exe');

    /* Home
    params : 
    1. Auth/
    */
    Route::post('home', 'HomeController@home');

    /* approval history
    params:
    auth/
    */
    Route::post('approval_history', 'HomeController@approval_history');

    /* account detail
    params:
    1. Auth/
     */
    Route::post('getAccountDetail', 'UserController@getAccountDetail');

    /* update approved
    params:
    1. Auth/
    2."approval_id" -> id approval yang akan di update

    */
    Route::post('updateToApproved', 'ApproversController@actionApprove');

    /* update reject
    params:
    1. Auth/
    2."approval_id" -> id approval yang akan di update
    */
    Route::post('updateToRejected', 'ApproversController@actionReject');



    });
