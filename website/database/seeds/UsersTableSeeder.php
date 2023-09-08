<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Applications\User\Model\User;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        /** @var User $Admin */
        $Admin = User::create([
            'id' => 1,
            'username' => 'administrator',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'is_disabled' => 0,
            'password' => bcrypt('password'),
        ]);
        DB::table('role_user')->insert([
            'user_id' => 1,
            'role_id' => 1,
        ]);

        /** @var User $Colaborator */
        $Colaborator = User::create([
            'id' => 2,
            'username' => 'collaborator',
            'first_name' => 'Collaborator',
            'last_name' => 'User',
            'email' => 'collaborator@example.com',
            'is_disabled' => 0,
            'password' => bcrypt('password'),
        ]);
        DB::table('role_user')->insert([
            'user_id' => 2,
            'role_id' => 2,
        ]);


        /** @var User $Public */
        $Public = User::create([
            'id' => 3,
            'username' => 'public',
            'first_name' => 'Public',
            'last_name' => 'User',
            'email' => 'public@example.com',
            'is_disabled' => 0,
            'password' => bcrypt('password'),
        ]);
        DB::table('role_user')->insert([
            'user_id' => 3,
            'role_id' => 3,
        ]);

        /** @var User $Colaborator */
        $Colaborator = User::create([
            'id' => 4,
            'username' => 'GOKIO',
            'first_name' => 'Goran',
            'last_name' => 'Stefanovskio',
            'email' => 'tevidma@example.com',
            'is_disabled' => 0,
            'password' => bcrypt('password'),
        ]);
        DB::table('role_user')->insert([
            'user_id' => 4,
            'role_id' => 2,
        ]);


        // foreach (range(3, 50) as $index) {
        //     $companyVat = $faker->numberBetween(1233, 4002);
        //     $company = $faker->company;

        //     /** @var User $Public */
        //     $Public = User::create([
        //         'id' => $index,
        //         'username' => 'public',
        //         'first_name' => $faker->firstName,
        //         'last_name' => $faker->lastName,
        //         'company' => $company,
        //         'company_vat' => $companyVat,
        //         'email' => $faker->companyEmail,
        //         'is_disabled' => 0,
        //         'password' => bcrypt('password'),
        //     ]);

        //     DB::table('role_user')->insert([
        //         'user_id' => $index,
        //         'role_id' => 3,
        //     ]);


        //     DB::table('details')->insert([
        //         'user_id' => $index,
        //         'type' => 'SHIPPING',
        //         'name' => 'Public User',
        //         'city' => $faker->city,
        //         'address' => $faker->address,
        //         'company' => $company,
        //         'company_vat' => $companyVat,
        //         'country_id' => 581,
        //         'phone' => $faker->phoneNumber,
        //         'default' => true
        //     ]);

        // }


        try {
            $Admin->addMedia(public_path() . '/images/avatar.jpg')->preservingOriginal()->toMediaCollection('user_avatars');
            $Colaborator->addMedia(public_path() . '/images/bag-size-1.jpg')->preservingOriginal()->toMediaCollection('user_avatars');
            $Public->addMedia(public_path() . '/images/custom-bag-size.jpg')->preservingOriginal()->toMediaCollection('user_avatars');
        } catch (Exception $e) {
            echo ($e);
        }
    }
}
