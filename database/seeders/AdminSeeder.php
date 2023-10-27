<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        admin::updateOrCreate([
            'email' => 'rejajamil@gmail.com',
            'username' => 'admin'
          ], [
            'name' => 'Reja Jamil',
            'password' => Hash::make('admin')
          ]);
    }
}
