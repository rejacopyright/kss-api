<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('test', 'test@index');

Route::post('login', 'auth\admin_login_c@login');
Route::get('logout', 'auth\admin_login_c@logout');
Route::post('forgot-password', 'auth\admin_password_c@forgot');
Route::post('reset-password', 'auth\admin_password_c@reset');
Route::post('invalidate-token', 'auth\admin_password_c@invalidateToken');

Route::get('test/role', 'test@testRole');
Route::group(["middleware" => "auth:admin-api"], function () {
    Route::get('/', function () {
        return 'protected admin';
    });
    Route::get('me', 'auth\admin_login_c@me');

    // DASHBOARD
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('analytics', 'dashboard_c@analytics');
    });

    // HOME
    Route::group(['prefix' => 'home'], function () {
        Route::get('popup', 'home_c@getPopup');
        Route::post('popup', 'home_c@addPopup');
        Route::put('popup/{id}', 'home_c@editPopup');
        Route::put('popup/{id}/status', 'home_c@statusPopup');
        Route::delete('popup/{id}', 'home_c@deletePopup');
        Route::get('banner', 'home_c@getBanner');
        Route::post('banner', 'home_c@addBanner');
        Route::put('banner/{id}', 'home_c@editBanner');
        Route::delete('banner/{id}', 'home_c@deleteBanner');
        Route::post('assets', 'home_c@addAssets');
        Route::put('assets/{id}', 'home_c@editAssets');
        Route::delete('assets/{id}', 'home_c@deleteAssets');
        Route::post('customer', 'home_c@addCustomer');
        Route::put('customer/{id}', 'home_c@editCustomer');
        Route::delete('customer/{id}', 'home_c@deleteCustomer');
    });

    // BANNER
    Route::put('banner/{module}', 'banner_c@editBanner');

    // NEWS
    Route::group(['prefix' => 'news'], function () {
        Route::get('media', 'news_media_c@getMedia');
        Route::post('media', 'news_media_c@addMedia');
        Route::put('media/{id}', 'news_media_c@editMedia');
        Route::delete('media/{id}', 'news_media_c@deleteMedia');
        Route::post('carreer', 'news_carreer_c@addCarreer');
        Route::put('carreer/{id}', 'news_carreer_c@editCarreer');
        Route::delete('carreer/{id}', 'news_carreer_c@deleteCarreer');
    });

    // SERVICES
    Route::post('services', 'services_c@addServices');
    Route::put('services/{id}', 'services_c@editServices');
    Route::delete('services/{id}', 'services_c@deleteServices');

    // ABOUT
    Route::put('about/{scope}', 'about_c@editAbout');

    // SETTINGS
    Route::group(['prefix' => 'settings'], function () {
        Route::put('social', 'settings_c@editSocial');
        Route::put('contact', 'settings_c@editContact');
    });

    // USERS
    Route::get('user', 'admin_c@getAdmin');
    Route::get('user/{id}', 'admin_c@detailAdmin');
    Route::post('user', 'admin_c@addAdmin');
    Route::put('user/{id}', 'admin_c@editAdmin');
    Route::delete('user/{id}', 'admin_c@deleteAdmin');
});
