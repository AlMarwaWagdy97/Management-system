<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //  sync routes in permissions
        $permissions = Permission::query()->get();
        syncPermisions($permissions);

        // role adminstartor
        $role = Role::where('name','administrator')->get()->first();
        if($role== null){
            $role = Role::create([
                    'name' => 'administrator',
                    'guard_name' => 'account'
                ]);
        }
        // sync role by permissions
        $role->syncPermissions(Permission::query()->get()->pluck('id')->toArray());
    }
}
