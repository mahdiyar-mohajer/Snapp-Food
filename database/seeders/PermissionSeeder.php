<?php

namespace Database\Seeders;

use App\Enums\Role as enum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

// Create and assign permissions
        $permissions = [
            'promote-to-admin','accept admin', 'add food category', 'delete food category',
            'add restaurant category', 'delete restaurant category', 'delete seller',
            'delete food', 'define coupon', 'add coupon', 'define banner',
            'add banner', 'view user', 'view users', 'view sellers', 'add restaurant', 'define food',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

// Create roles
        $roles = enum::getValues();
        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

// Assign permissions to roles
        $admin = Role::findByName('admin');
        $admin->givePermissionTo(Permission::all()->except('delete food'));

        $seller = Role::findByName('seller');
        $seller->givePermissionTo([
            'add coupon', 'delete food', 'add banner', 'add restaurant', 'define food',
        ]);

// Create sample users and assign roles
        $this->createUser('مهدیار', '09126899864','mahdiyar@gmail.com', '123456', $admin);
        $this->createUser('فروشنده 1', '09126899864','test@gmail.com', '123456', $seller);
        $this->createUser('فروشنده2', '09126899864','test2@gmail.com', '123456', $seller);
        $this->createUser('فروشنده3', '09126899864','test3@gmail.com', '123456', $seller);
    }

    private function createUser($name,$phone, $email, $password, $role)
    {
        $user = User::factory()->create([
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $user->assignRole($role);
    }
}
