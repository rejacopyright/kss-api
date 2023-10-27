<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Models\admin;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // ========================== PERMISSIONS ==========================

        // HOME
        Permission::create(['name' => 'home', 'guard_name' => 'admin-api']);
        Permission::create(['name' => 'home.banner', 'guard_name' => 'admin-api']);
        Permission::create(['name' => 'home.asset', 'guard_name' => 'admin-api']);
        Permission::create(['name' => 'home.customer', 'guard_name' => 'admin-api']);
        // ABOUT
        Permission::create(['name' => 'about', 'guard_name' => 'admin-api']);
        Permission::create(['name' => 'about.company', 'guard_name' => 'admin-api']);
        Permission::create(['name' => 'about.history', 'guard_name' => 'admin-api']);
        Permission::create(['name' => 'about.vision', 'guard_name' => 'admin-api']);
        Permission::create(['name' => 'about.organization', 'guard_name' => 'admin-api']);
        Permission::create(['name' => 'about.certification', 'guard_name' => 'admin-api']);
        Permission::create(['name' => 'about.management', 'guard_name' => 'admin-api']);
        // NEWS
        Permission::create(['name' => 'news', 'guard_name' => 'admin-api']);
        Permission::create(['name' => 'news.media', 'guard_name' => 'admin-api']);
        Permission::create(['name' => 'news.carreer', 'guard_name' => 'admin-api']);
        // SERVICES
        Permission::create(['name' => 'services', 'guard_name' => 'admin-api']);
        Permission::create(['name' => 'services.general', 'guard_name' => 'admin-api']);
        Permission::create(['name' => 'services.marine', 'guard_name' => 'admin-api']);
        // SETTINGS
        Permission::create(['name' => 'settings', 'guard_name' => 'admin-api']);
        Permission::create(['name' => 'settings.social', 'guard_name' => 'admin-api']);
        Permission::create(['name' => 'settings.contact', 'guard_name' => 'admin-api']);
        // USERS
        Permission::create(['name' => 'users', 'guard_name' => 'admin-api']);


        // ========================== ROLES ==========================
        $role = Role::create(['name' => 'super-admin', 'guard_name' => 'admin-api']);
        $role = Role::create(['name' => 'admin', 'guard_name' => 'admin-api']);
    }
}
