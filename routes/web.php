<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', function () {
    return 'Kamu tidak memiliki akses';
})->name('login');

Route::get('home/popup', 'home_c@getPopup');
Route::get('home/banner', 'home_c@getBanner');
Route::get('home/assets', 'home_c@getAssets');
Route::get('home/customer', 'home_c@getCustomer');
Route::get('banner', 'banner_c@getBanner');
Route::get('banner/{module}', 'banner_c@detailBanner');
Route::get('news/media', 'news_media_c@getMedia');
Route::get('news/media/{id}', 'news_media_c@detailMedia');
Route::get('news/carreer', 'news_carreer_c@getCarreer');
Route::get('news/carreer/{id}', 'news_carreer_c@detailCarreer');
Route::get('services', 'services_c@getServices');
Route::get('services/{id}', 'services_c@detailServices');
Route::get('about', 'about_c@getAbout');
Route::get('about/{scope}', 'about_c@detailAbout');
Route::get('settings/social', 'settings_c@getSocial');
Route::get('settings/contact', 'settings_c@getContact');


Route::get('mail', function () {
    $data = collect([]);
    $data['url'] = 'https://oke.com/test';
    $data['token'] = 'token';
    return view('mail.forgot-password', compact('data'));
});
