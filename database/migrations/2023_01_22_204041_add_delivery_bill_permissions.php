<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class AddDeliveryBillPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permissions = [
            'delivery-bill-list',
            'delivery-bill-create',
            'delivery-bill-edit',
            'delivery-bill-delete'
        ];
         foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        } 
        
        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
