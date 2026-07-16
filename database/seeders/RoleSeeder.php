<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {

        Role::create([
            'name' => 'super_admin',
            'display_name' => 'Super Admin'
        ]);


        Role::create([
            'name' => 'manager',
            'display_name' => 'Manager'
        ]);


        Role::create([
            'name' => 'accountant',
            'display_name' => 'Accountant'
        ]);


        Role::create([
            'name' => 'technician',
            'display_name' => 'Technician'
        ]);


        Role::create([
            'name' => 'cashier',
            'display_name' => 'Cashier'
        ]);

    }
}