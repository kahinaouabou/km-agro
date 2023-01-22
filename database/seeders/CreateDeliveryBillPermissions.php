<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


use Spatie\Permission\Models\Role;

use Spatie\Permission\Models\Permission;

class CreateDeliveryBillPermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name' , 'Admin')->get();
       
        $permissionsArray = [
            'delivery-bill-list',
            'delivery-bill-create',
            'delivery-bill-edit',
            'delivery-bill-delete'
        ];

        $permissions = Permission::whereIn('name',$permissionsArray)->get();

        $role->syncPermissions($permissions);

        $role = Role::where('name' , 'Comptable');

        $permissionsArray = [
            'delivery-bill-list',
            'delivery-bill-create'
         ];

        $permissions = Permission::whereIn('name',$permissionsArray)->get();

        $role->syncPermissions($permissions);
    }
}
