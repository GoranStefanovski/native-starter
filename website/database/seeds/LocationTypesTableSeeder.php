<?php

use Illuminate\Database\Seeder;
use App\Applications\Common\Model\LocationTypes;

class LocationTypesTableSeeder extends Seeder
{
    public function run()
    {
        $locationTypes = [
            ['id' => 1, 'name' => 'Restaurant', 'order' => 1],
            ['id' => 2, 'name' => 'Bar', 'order' => 2],
            ['id' => 3, 'name' => 'Nightclub', 'order' => 3],
            ['id' => 4, 'name' => 'Cafe', 'order' => 4],
            ['id' => 5, 'name' => 'Pub', 'order' => 5],
            ['id' => 6, 'name' => 'Music Venue', 'order' => 6],
            ['id' => 7, 'name' => 'Art Gallery', 'order' => 7],
            ['id' => 8, 'name' => 'Theater', 'order' => 8],
            ['id' => 9, 'name' => 'Movie Theater', 'order' => 9],
            ['id' => 10, 'name' => 'Shopping Mall', 'order' => 10],
        ];

        foreach ($locationTypes as $type) {
            LocationTypes::create([
                'id' => $type['id'],
                'name' => $type['name'],
                'order' => $type['order']
            ]);
        }
    }
}