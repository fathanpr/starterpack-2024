<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        Role::create([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'customer',
            'guard_name' => 'web'
        ]);

        $permissions = [
            'category create', 'category read', 'category update', 'category delete', 'category destroy', 'category restore', 'post create',
            'post read', 'post update', 'post delete', 'post destroy', 'post restore', 'user create', 'user read', 'user update', 'user delete', 'read all'
        ];

        $permissionCustomer = [
            'user read', 'user update', 'user delete',
        ];

        foreach ($permissions as $key => $value) {
            Permission::create([
                'name' => $value,
                'guard_name' => 'web'
            ]);
        }

        /**
         * # CREATE USER
         * 1. admin
         */
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'email_verified_at' => time(),
        ]);

        $admin->assignRole('admin');

        /**
         * # CREATE USER
         * 2. Customer
         */
        $admin = User::factory()->create([
            'name' => 'Customer',
            'email' => 'customer@example.com',
            'password' => bcrypt('12345678'),
            'email_verified_at' => time(),
        ]);

        $admin->assignRole('customer');

        /** give role permissions */
        $roleAdmin = Role::findByName('admin');
        $roleAdmin->syncPermissions($permissions);

        $roleCustomer = Role::findByName('customer');
        $roleCustomer->syncPermissions($permissionCustomer);
    }
}
