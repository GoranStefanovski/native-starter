<?php
namespace Database\Seeders;

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
//        $this->call(CountriesSeeder::class);
//        $this->call(RolesTableSeeder::class);
//        $this->call(UsersTableSeeder::class);
//        $this->call(PermissionTableSeeder::class);
        $this->call(LaravelEntrustSeeder::class);
        $this->call(PageSeeder::class);
    }
}
