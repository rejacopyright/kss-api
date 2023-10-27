<?php
return [
    'defaults' => ['guard' => 'users', 'passwords' => 'users',],
    'guards' => [
        'users' => ['driver' => 'session', 'provider' => 'users',],
        'api' => ['driver' => 'jwt', 'provider' => 'users',],
        'admin' => ['driver' => 'session', 'provider' => 'admin',],
        'admin-api' => ['driver' => 'jwt', 'provider' => 'admin',],
    ],
    'providers' => [
        'users' => ['driver' => 'eloquent', 'model' => App\Models\User::class,],
        'admin' => ['driver' => 'eloquent', 'model' => App\Models\admin::class,],
    ],
    'passwords' => [
        'users' => ['provider' => 'users', 'table' => 'password_resets', 'expire' => 60, 'throttle' => 60,],
        'admin' => ['provider' => 'admin', 'table' => 'password_resets', 'expire' => 60, 'throttle' => 60,],
    ],
    'password_timeout' => 10800,
];
