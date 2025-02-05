<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['guard_name' => 'web', 'name' => 'dashboard']);
        Permission::create(['guard_name' => 'web', 'name' => 'manage-users']);
        Permission::create(['guard_name' => 'web', 'name' => 'posts']);

        // create roles and assign existing permissions
        $role1 = Role::create([
            'guard_name' => 'web',
            'name' => 'admin',
        ]);

        // give permission to admin role
        $role1->givePermissionTo('dashboard');
        $role1->givePermissionTo('manage-users');

        // creating moderator role
        $role2 = Role::create([
            'guard_name' => 'web',
            'name' => 'moderator',
        ]);

        // give permission to moderator role
        $role2->givePermissionTo('dashboard');

        // create user role
        $role3 = Role::create([
            'guard_name' => 'web',
            'name' => 'user',
        ]);

        // create users
        $user = User::create([
            'country_id' => Country::inRandomOrder()->first()->id,
            'name' => 'Test User',
            'email' => 'test@example.com',
            'email_verified_at' => now(),
            'phone' => '998981600609',
            'phone_verified_at' => now(),
            'password' => 12345678
        ]);

        // create point items
        $user->point()->create();

        // assign admin role
        $user->assignRole($role1);
        $user->givePermissionTo('posts');

        // creating fake users
        User::factory(9)->create()->map(function ($user) use ($role3) {
            $user->point()->create();
            $user->assignRole($role3);
        });
    }
}
