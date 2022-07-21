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
Route::group(['middleware' => 'api', 'prefix' => 'v1','namespace' => 'Api\V1'], function(){
    Route::post('register','AuthController@register');
    Route::post('login','AuthController@login');
    Route::post('forget_password', 'AuthController@forgot');
    Route::post('password/reset', 'AuthController@reset');
});


Route::group(['middleware' => 'auth:api', 'prefix' => 'v1', 'namespace' => 'Api\V1'], function () {
    Route::get('logout','AuthController@logout');
});


