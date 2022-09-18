<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\home_customer;

class HomeCustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['index' => 1, 'title' => 'Customer 1'],
            ['index' => 2, 'title' => 'Customer 2'],
            ['index' => 3, 'title' => 'Customer 3'],
            ['index' => 4, 'title' => 'Customer 4'],
            ['index' => 5, 'title' => 'Customer 5'],
            ['index' => 6, 'title' => 'Customer 6'],
        ];

        foreach ($data as $item) {
            $updater = collect($item)->only(['title'])->toArray();
            $creator = collect($item)->except(['title'])->toArray();
            home_customer::updateOrCreate($updater, $creator);
        }
    }
}
