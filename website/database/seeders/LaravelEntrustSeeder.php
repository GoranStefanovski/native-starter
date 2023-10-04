<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Applications\User\Model\User;
use App\Applications\User\Model\Permission;
use App\Applications\User\Model\Role;
use Faker\Factory as Faker;

class LaravelEntrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        $this->command->info('Truncating Roles, Permissions and Users tables');
        $this->truncateEntrustTables();

        $config = config('entrust_seeder.role_structure');
        $userRoles = config('entrust_seeder.user_roles');
        $mapPermission = collect(config('entrust_seeder.permissions_map'));

        foreach ($config as $key => $modules) {
            $role = $this->createRole($key);
            $permissions = $this->createPermissions($modules, $mapPermission);

            // Attach all permissions to the role
            $role->permissions()->sync($permissions);

            if(isset($userRoles[$key])) {
                if (is_array($userRoles[$key])) {
                    $this->createUsersForRoleFromArray($userRoles[$key], $role);
                } else if (is_int($userRoles[$key])) {
                    $this->createUsersForRoleByNumber($userRoles[$key], $role);
                }
            }
        }
    }

    /**
     * Create users for a role from array of users.
     *
     * @param array $role_users An array of user data for the role.
     * @param Role $role The role to which users are associated.
     *
     * @return void
     */
    private function createUsersForRoleFromArray($role_users, $role)
    {
        foreach ($role_users as $role_user) {
            $this->createUser($role_user, $role);
        }
    }

    /**
     * Create users for a role by number.
     *
     * @param int $number_of_users Number of users to be created.
     * @param Role $role The role to which users are associated.
     *
     * @return void
     */
    private function createUsersForRoleByNumber(int $number_of_users, Role $role)
    {
        for ($i = 1; $i <= $number_of_users; $i++) {
            $this->createUser([], $role);
        }
    }

    /**
     * Create a new role.
     *
     * @param string $key The role key.
     *
     * @return Role
     */
    private function createRole(string $key)
    {
        $this->command->info('Creating Role ' . strtoupper($key));
        return Role::create([
            'name' => $key,
            'display_name' => ucwords(str_replace('_', ' ', $key)),
            'description' => ucwords(str_replace('_', ' ', $key)),
        ]);
    }

    /**
     * Create permissions for a role.
     *
     * @param array $modules The modules associated with the role.
     * @param Collection $mapPermission A collection of permission mappings.
     *
     * @return array An array of permission IDs.
     */
    private function createPermissions(array $modules, Collection $mapPermission)
    {
        $permissions = [];

        foreach ($modules as $module => $value) {
            foreach (explode(',', $value) as $p => $perm) {
                $permissionValue = $mapPermission->get($perm);

                $permissions[] = Permission::firstOrCreate([
                    'name' => $permissionValue . '-' . $module,
                    'display_name' => ucfirst($permissionValue) . ' ' . ucwords(str_replace('_', ' ', $module)),
                    'description' => ucfirst($permissionValue) . ' ' . ucwords(str_replace('_', ' ', $module)),
                ])->id;

                $this->command->info('Creating Permission to ' . $permissionValue . ' for ' . $module);
            }
        }

        return $permissions;
    }

    /**
     * Create a new user and associate them with a given role.
     *
     * @param  array  $role_user  The user data to be created, including role assignment.
     * @param  Role   $role       The role to be assigned to the user.
     *
     * @return void
     */
    private function createUser(array $role_user, Role $role)
    {
        try {
            $role_user = $this->prepareUserData($role_user);
            $user = User::create($role_user);
            $user->attachRole($role);
            $user->addMedia(public_path() . '/images/avatar.jpg')
                ->preservingOriginal()
                ->toMediaCollection('user_avatars');
        } catch (Exception $e) {
            $this->command->error($e);
        }
    }

    /**
     * Truncates all the entrust tables and the users table
     *
     * @return    void
     */
    private function truncateEntrustTables()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('permission_role')->truncate();
        DB::table('role_user')->truncate();
        DB::table('users')->truncate();

        Role::truncate();
        Permission::truncate();

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Prepare data for the users
     *
     * @return array
     */
    private function prepareUserData(array $user){
        $faker = Faker::create();
        $user["username"] = $user["username"] ?? $faker->userName;
        $user["first_name"] = $user["first_name"] ?? $faker->firstName;
        $user["last_name"] = $user["last_name"] ?? $faker->lastName;
        $user["email"] = $user["email"] ?? $faker->email;
        $user["password"] = Hash::make('password');
        $user["is_disabled"] = 0;
        $user["company"] = $faker->company;
        $user["phone"] = $faker->phoneNumber;
        $user["company_vat"] = $faker->numberBetween(1233, 4002);

        return $user;
    }
}
