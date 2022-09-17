<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', function () {
    return 'Kamu tidak memiliki akses';
})->name('login');

Route::get('home/banner', 'home_c@getBanner');
Route::get('home/assets', 'home_c@getAssets');
Route::get('news/media', 'news_media_c@getMedia');
Route::get('news/media/{id}', 'news_media_c@detailMedia');
Route::get('services', 'services_c@getServices');
Route::get('services/{id}', 'services_c@detailServices');
Route::get('about', 'about_c@getAbout');
Route::get('about/{scope}', 'about_c@detailAbout');
