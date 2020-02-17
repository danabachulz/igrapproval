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


//login
Route::post('login', 'UserController@login');

//register
Route::post('register', 'UserController@register');

/* update approved
params:
1."account_id" -> account id user
2."approval_id" -> id approval yang akan di update
*/
Route::post('updateToApproved', 'ApproversController@actionApprove');

/* update reject
params:
1."account_id" -> account id user
2."approval_id" -> id approval yang akan di update
*/
Route::post('updateToRejected', 'ApproversController@actionReject');


/* Middleware */
Route::group(['middleware' => 'auth:api'], function(){

    //testing
    Route::post('tes', 'TestController@exe');

    //home
    Route::post('home', 'HomeController@home');

    /* account detail
    params:
    1."account_id" -> account id user
    */
    Route::post('getAccountDetail', 'UserController@getAccountDetail');

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
