<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubcontractingBillReferenceFieldsToSettingsTable extends Migration
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
            $table->boolean('subcontracting_bill_ref_auto');
            $table->boolean('subcontracting_bill_date_position');
            $table->string('subcontracting_bill_prefix',2);
            $table->integer('subcontracting_bill_size');
            $table->integer('subcontracting_bill_next_ref');
        });
        DB::table('settings')->update([
            'id'=>1,
            'subcontracting_bill_ref_auto'=>'1', 
            'subcontracting_bill_date_position'=>'1', 
            'subcontracting_bill_prefix'=>'BS', 
            'subcontracting_bill_size'=>4, 
            'subcontracting_bill_next_ref'=>1
    
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
