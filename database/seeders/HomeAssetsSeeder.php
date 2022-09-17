<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\home_assets;

class HomeAssetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['index' => 1, 'count' => '25+', 'title' => 'Million Tons/Year', 'description' => 'The biggest international hub & bulk port in Indonesia'],
            ['index' => 2, 'count' => '17', 'title' => 'Slots Jetty', 'description' => 'Equipped with the best jetty facilities for loading & unloading'],
            ['index' => 3, 'count' => '-21', 'title' => 'Meter Low Water Spring', 'description' => 'Accommodated various type of vessels ranging from 10.000 - 200.000 DWT (super capesize vessel)'],
            ['index' => 4, 'count' => '20K+', 'title' => 'Metric Tons/Day', 'description' => 'High discharging rate for food & feed cargos'],
        ];
        foreach ($data as $item) {
            $updater = collect($item)->only(['title'])->toArray();
            $creator = collect($item)->except(['title'])->toArray();
            home_assets::updateOrCreate($updater, $creator);
        }
    }
}
