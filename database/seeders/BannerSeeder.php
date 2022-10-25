<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\banner;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['module' => 'about'],
            ['module' => 'services'],
            ['module' => 'news'],
            ['module' => 'contact'],
        ];

        foreach ($data as $item) {
            banner::updateOrCreate($item);
        }
    }
}
