<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\settings_contact;

class SettingsContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        settings_contact::updateOrCreate([
            'contact' => 'Jl. ABC No. 123',
            'map' => 'Jl. ABC No. 123',
        ]);
    }
}
