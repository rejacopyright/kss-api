<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\about;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['index' => 1, 'scope' => 'company', 'title' => 'Company Profile', 'description' => 'Company Profile'],
            ['index' => 2, 'scope' => 'history', 'title' => 'History', 'description' => 'History'],
            ['index' => 3, 'scope' => 'vision', 'title' => 'Vision, Mission & Values', 'description' => 'Vision, Mission & Values'],
            ['index' => 4, 'scope' => 'organization', 'title' => 'Organization Structure', 'description' => 'Organization Structure'],
            ['index' => 5, 'scope' => 'certification', 'title' => 'Certification', 'description' => 'Certification'],
            ['index' => 6, 'scope' => 'management', 'title' => 'Management', 'description' => 'Management'],
            ['index' => 7, 'scope' => 'commissioners', 'title' => 'Board of Commissioners', 'description' => 'Board of Commissioners', 'parent' => 'management'],
            ['index' => 8, 'scope' => 'directors', 'title' => 'Board of Directors', 'description' => 'Board of Directors', 'parent' => 'management'],
        ];
        foreach ($data as $item) {
            $updater = collect($item)->only(['scope'])->toArray();
            $creator = collect($item)->except(['scope'])->toArray();
            about::updateOrCreate($updater, $creator);
        }
    }
}
