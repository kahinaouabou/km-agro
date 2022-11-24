<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDamageBillReferenceFieldsToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
            $table->boolean('damage_bill_ref_auto');
            $table->boolean('damage_bill_date_position');
            $table->string('damage_bill_prefix',2);
            $table->integer('damage_bill_size');
            $table->integer('damage_bill_next_ref');
        });
        DB::table('settings')->update([
            'id'=>1,
            'damage_bill_ref_auto'=>'1', 
            'damage_bill_date_position'=>'1', 
            'damage_bill_prefix'=>'BV', 
            'damage_bill_size'=>3, 
            'damage_bill_next_ref'=>1
    
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
}
