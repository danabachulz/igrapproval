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

//testing
Route::post('tes', 'TestController@exe');

//login
Route::post('login', 'UserController@login');

//register
Route::post('register', 'UserController@register');

//account detail
Route::post('getAccountDetail', 'AccountsController@getAccountDetail');

Route::group(['middleware' => 'auth:api'], function(){

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
