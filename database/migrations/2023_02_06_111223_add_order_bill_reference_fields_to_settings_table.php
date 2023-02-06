<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderBillReferenceFieldsToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            Schema::table('settings', function (Blueprint $table) {
                //
                $table->boolean('order_bill_ref_auto');
                $table->boolean('order_bill_date_position');
                $table->string('order_bill_prefix',2);
                $table->integer('order_bill_size');
                $table->integer('order_bill_next_ref');
            });
            DB::table('settings')->update([
                'id'=>1,
                'order_bill_ref_auto'=>'1', 
                'order_bill_date_position'=>'1', 
                'order_bill_prefix'=>'BC', 
                'order_bill_size'=>4, 
                'order_bill_next_ref'=>1
        
            ]);
        });
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
