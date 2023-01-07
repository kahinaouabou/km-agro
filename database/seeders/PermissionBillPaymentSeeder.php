<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;

class PermissionBillPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [


            'bill-list',
 
            'bill-create',
 
            'bill-edit',
 
            'bill-delete',

            'payment-list',
 
            'payment-create',
 
            'payment-edit',
 
            'payment-delete'
 
         ];
 
      
 
         foreach ($permissions as $permission) {
 
              Permission::create(['name' => $permission]);
 
         }
    }
}
