<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeliveryBillReferenceFieldsToSettingsTable extends Migration
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
            $table->boolean('delivery_bill_ref_auto');
            $table->boolean('delivery_bill_date_position');
            $table->string('delivery_bill_prefix',2);
            $table->integer('delivery_bill_size');
            $table->integer('delivery_bill_next_ref');
        });
        DB::table('settings')->update([
            'id'=>1,
            'delivery_bill_ref_auto'=>'1', 
            'delivery_bill_date_position'=>'1', 
            'delivery_bill_prefix'=>'BL', 
            'delivery_bill_size'=>3, 
            'delivery_bill_next_ref'=>1
    
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
