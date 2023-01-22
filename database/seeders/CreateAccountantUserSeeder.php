<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;

use Spatie\Permission\Models\Role;

use Spatie\Permission\Models\Permission;

class CreateAccountantUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
    

        $role = Role::create(['name' => 'Comptable']);
        $permissionsArray = [
            'bill-list',
            'bill-create',
            'payment-list',
            'payment-create',
        ];

        $permissions = Permission::whereIn('name',$permissionsArray)->get();

        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}
