<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\settings_social;

class SettingsSocialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'email'],
            ['name' => 'facebook'],
            ['name' => 'twitter'],
            ['name' => 'instagram'],
            ['name' => 'youtube'],
            ['name' => 'linkedin'],
            ['name' => 'whatsapp'],
        ];

        foreach ($data as $item) {
            settings_social::updateOrCreate($item);
        }
    }
}
