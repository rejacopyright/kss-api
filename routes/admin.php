<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('test', 'test@index');

Route::post('login', 'auth\admin_login_c@login');
Route::get('logout', 'auth\admin_login_c@logout');

Route::group(["middleware" => "auth:admin-api"], function () {
    Route::get('/', function () {
        return 'protected admin';
    });
    Route::get('me', 'auth\admin_login_c@me');
    Route::group(['prefix' => 'home'], function () {
        Route::get('banner', 'home_c@getBanner');
        Route::post('banner', 'home_c@addBanner');
        Route::put('banner/{id}', 'home_c@editBanner');
        Route::delete('banner/{id}', 'home_c@deleteBanner');
    });
});
