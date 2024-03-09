<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['user', 'administrator'];

        foreach($roles as $role){
            $roleObj = new Roles();
            $roleObj->role_name = $role;
            $roleObj->save();
        }
    }
}
