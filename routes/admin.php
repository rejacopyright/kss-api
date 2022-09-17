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

    // HOME
    Route::group(['prefix' => 'home'], function () {
        Route::get('banner', 'home_c@getBanner');
        Route::post('banner', 'home_c@addBanner');
        Route::put('banner/{id}', 'home_c@editBanner');
        Route::delete('banner/{id}', 'home_c@deleteBanner');
        Route::post('assets', 'home_c@addAssets');
        Route::put('assets/{id}', 'home_c@editAssets');
        Route::delete('assets/{id}', 'home_c@deleteAssets');
    });

    // NEWS
    Route::group(['prefix' => 'news'], function () {
        Route::get('media', 'news_media_c@getMedia');
        Route::post('media', 'news_media_c@addMedia');
        Route::put('media/{id}', 'news_media_c@editMedia');
        Route::delete('media/{id}', 'news_media_c@deleteMedia');
    });

    // SERVICES
    Route::post('services', 'services_c@addServices');
    Route::put('services/{id}', 'services_c@editServices');
    Route::delete('services/{id}', 'services_c@deleteServices');

    // ABOUT
    Route::put('about/{scope}', 'about_c@editAbout');
});
