<?php

use App\Applications\Common\Model\SubTypes;
use Illuminate\Database\Seeder;

class SubTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SubTypes::create([
            'id' => 1,
            'name' => 'Premium',
        ]);
        SubTypes::create([
            'id' => 2,
            'name' => 'Top Premium'
        ]);
        SubTypes::create([
            'id' => 3,
            'name' => 'Top Premium +'
        ]);
    }
}
