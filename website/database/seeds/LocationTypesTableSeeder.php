<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Applications\Common\Model\LocationTypes;

class LocationTypesTableSeeder extends Seeder
{
    public function run()
    {
        $locationTypes = [
            ['id' => 1, 'name' => 'Restaurant'],
            ['id' => 2, 'name' => 'Bar'],
            ['id' => 3, 'name' => 'Nightclub'],
            ['id' => 4, 'name' => 'Cafe'],
            ['id' => 5, 'name' => 'Pub'],
            ['id' => 6, 'name' => 'Music Venue'],
            ['id' => 7, 'name' => 'Art Gallery'],
            ['id' => 8, 'name' => 'Theater'],
            ['id' => 9, 'name' => 'Movie Theater'],
            ['id' => 10, 'name' => 'Shopping Mall'],
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