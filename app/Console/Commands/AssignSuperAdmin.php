<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Role;

class AssignSuperAdmin extends Command
{

    protected $signature = 'app:assign-super-admin';

    protected $description = 'Assign Super Admin role to user';


    public function handle()
    {

        $user = User::where(
            'email',
            'fies6000@gmail.com'
        )->first();


        if (!$user) {

            $this->error('User not found');

            return;

        }


        $role = Role::where(
            'name',
            'super_admin'
        )->first();


        if (!$role) {

            $this->error('Role not found');

            return;

        }


        $user->role_id = $role->id;

        $user->save();


        $this->info(
            'Super Admin assigned successfully'
        );

    }

}