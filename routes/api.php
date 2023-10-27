<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('test', 'test@index');

Route::group(["middleware" => "auth:api"], function () {
    Route::get('protected', function () {
        return 'protected user';
    });
});
