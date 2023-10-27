<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\admin;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class test extends Controller
{
   function index()
   {
      return 'oke index';
   }
   function testRole()
   {
      // $admin = admin::where('username', 'admin')->first();
      // $admin->syncRoles('super-admin');
      // dd(admin::role('super-admin')->distinct('id')->pluck('id')->all());
      return 'ok';
   }
}
