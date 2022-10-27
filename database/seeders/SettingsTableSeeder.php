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
        DB::table('settings')->update([
            'id'=>1,
            'weigh_bill_ref_auto'=>'1', 
            'weigh_bill_date_position'=>'1', 
            'weigh_bill_prefix'=>'BP', 
            'weigh_bill_size'=>4, 
            'weigh_bill_next_ref'=>1
    
        ]);
    }
}
