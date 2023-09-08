<?php

use App\Applications\User\Model\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'id' => 1,
            'name' => 'user_write',
            'display_name' => 'User Write',
            'description' => 'Gives the user the role to add/edit/delete users on a system level'
        ]);
        Permission::create([
            'id' => 2,
            'name' => 'user_view',
            'display_name' => 'User View',
            'description' => 'Gives the user the role to view users on a system level'
        ]);

        // Public User Permission
        Permission::create([
            'id' => 3,
            'name' => 'public_user',
            'display_name' => 'Public User Access',
            'description' => 'Gives the user the role to view public user features section'
            ]);

                 // Locations Permissions
        Permission::create([
            'id' => 4,
            'name' => 'locations_write',
            'display_name' => 'Locations Write',
            'description' => 'Gives the user the role to add/edit/delete users on a system level'
        ]);
        Permission::create([
            'id' => 5,
            'name' => 'locations_view',
            'display_name' => 'Locations View',
            'description' => 'Gives the user the role to view users on a system level'
        ]);

        // Events Permissions
        Permission::create([
            'id' => 6,
            'name' => 'events_write',
            'display_name' => 'events Write',
            'description' => 'Gives the user the role to add/edit/delete users on a system level'
        ]);
        Permission::create([
            'id' => 7,
            'name' => 'events_view',
            'display_name' => 'events View',
            'description' => 'Gives the user the role to view users on a system level'
        ]);

        Permission::create([
            'id' => 8,
            'name' => 'admin_access',
            'display_name' => 'Admin Access',
            'description' => 'Gives the user the role to access the admin panel'
        ]);

        // Admin permissions (all permissions)
        for($i=1; $i<=8; ++$i){
            DB::table('permission_role')->insert([
                'permission_id' => $i,
                'role_id' => 1,
            ]);
        }

        // Collaborator permissions (just view permissions)
        $array = [4,5,6,7,8];
        foreach ($array as $value){
            DB::table('permission_role')->insert([
                'permission_id' => $value,
                'role_id' => 2,
            ]);
        }

        // Public user permission (just public user features permission)
        DB::table('permission_role')->insert([
            'permission_id' => 3,
            'role_id' => 3,
        ]);
    }
}
