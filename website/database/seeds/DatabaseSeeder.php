<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountriesSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(MusicTypesTableSeeder::class);
        $this->call(LocationTypesTableSeeder::class);
        $this->call(SubTypesTableSeeder::class);
        //Migration of data from legacy system
//        $this->call(DataMigrationSeeder::class);
    }
}
