<?php

return [
    'models' => [
        'permission' => App\Models\Permission::class,
        'role' => App\Models\Role::class,
    ],
    'table_names' => [
        'roles' => 'auth_roles',
        'permissions' => 'auth_permissions',
        'model_has_permissions' => 'auth_model_has_permissions',
        'model_has_roles' => 'auth_model_has_roles',
        'role_has_permissions' => 'auth_role_has_permissions',
    ],
    'column_names' => [
        'role_pivot_key' => null, //default 'role_id',
        'permission_pivot_key' => null, //default 'permission_id',
        'model_morph_key' => 'model_uuid',
        'team_foreign_key' => 'team_id',
    ],
    'register_permission_check_method' => true,
    'register_octane_reset_listener' => false,
    'teams' => false,
    'use_passport_client_credentials' => false,
    'display_permission_in_exception' => false,
    'display_role_in_exception' => false,
    'enable_wildcard_permission' => false,
    'cache' => [
        'expiration_time' => \DateInterval::createFromDateString('24 hours'),
        'key' => 'spatie.permission.cache',
        'store' => 'default',
    ],
];
