<?php
use Illuminate\Support\Facades\Route;

/**
 * This file require Access Token from Oauth Service: (oauth/token)
 */
Route::post('/user/login', 'Api\UserController@login')->name('login');
Route::post('/user/create','Api\UserController@create')->name('user.create');
Route::post('/user/resetpassword', 'Api\UserController@resetPassword')->name('user.resetpassword');

/**
 * Setup routes for search operations.
 */
Route::post('/search/photos', 'Api\SearchController@search')->name('search');
