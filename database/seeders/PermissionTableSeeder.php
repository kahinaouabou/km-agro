<?php

  

namespace Database\Seeders;

  

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;

  

class PermissionTableSeeder extends Seeder

{

    /**

     * Run the database seeds.

     *

     * @return void

     */

    public function run()

    {

        $permissions = [


           'transaction-box-list',

           'transaction-box-create',

           'transaction-box-edit',

           'transaction-box-delete'

        ];

        foreach ($permissions as $permission) {

             Permission::create(['name' => $permission]);

        }

    }

}