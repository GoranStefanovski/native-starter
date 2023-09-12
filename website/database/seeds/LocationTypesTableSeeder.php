<?php

use Illuminate\Database\Seeder;
use App\Applications\Common\Model\LocationTypes;

class LocationTypesTableSeeder extends Seeder
{
    public function run()
    {
        $locationTypes = [
            ['name' => 'Restaurant', 'order' => 0],
            ['name' => 'Bar', 'order' => 1],
            ['name' => 'Nightclub', 'order' => 2],
            ['name' => 'Cafe', 'order' => 3],
            ['name' => 'Pub', 'order' => 4],
            ['name' => 'Music Venue', 'order' => 5],
            ['name' => 'Art Gallery', 'order' => 6],
            ['name' => 'Theater', 'order' => 7],
            ['name' => 'Movie Theater', 'order' => 8],
            ['name' => 'Shopping Mall', 'order' => 9],
        ];

        foreach ($locationTypes as $type) {
            LocationTypes::create([
                'name' => $type['name'],
                'order' => $type['order']
            ]);
        }
    }
}