<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\Models\User();
        $user->password = \Hash::make('admin');
        $user->email = 'admin@example.com';
        $user->name = 'Test';
        $user->save();

        $role1 = Role::create(['name' => 'weber', 'guard_name' => 'web']);
        $role1->users()->attach($user);

        $perm1 = Permission::create(['name' => 'nonapi', 'guard_name' => 'web']);
        $perm1->roles()->attach($role1);

        $role2 = Role::create(['name' => 'apier', 'guard_name' => 'api']);
        $role2->users()->attach($user);

        $perm2 = Permission::create(['name' => 'nonweb', 'guard_name' => 'api']);
        $perm2->roles()->attach($role2);
    }
}
