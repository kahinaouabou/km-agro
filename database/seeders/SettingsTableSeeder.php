<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([

            'name'=>'reference', 
            'payment_ref_auto'=>'1', 
            'payment_date_position'=>'1', 
            'payment_prefix'=>'P', 
            'payment_size'=>4, 
            'payment_next_ref'=>1, 
            'created_at'=>now(), 
            'updated_at'=>now()
    
        ]);
    }
}
