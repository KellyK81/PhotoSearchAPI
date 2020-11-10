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

/*
    Direct User:
        Login -> Client Credential Grant token | None
        Logout -> Access token
        Validate Token -> Access token
        resetPassword -> Access token
        Create -> Client Token
    Admin User:
        Update Information -> Client Token
*/

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('/user/validate/token', 'Api\UserController@validateToken')->name('validateToken');
    Route::post('/user/logout', 'Api\UserController@logout')->name('logout');
});