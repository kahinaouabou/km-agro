<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bills', function (Blueprint $table) {
            //
            $table->decimal('weight_discount_percentage',10 ,2)->default(0)->after('net');
            $table->decimal('unit_price',10 ,2)->default(0)->after('weight_discount_percentage');
            $table->decimal('discount_value',10 ,2)->default(0)->after('unit_price');
            $table->decimal('net_payable',10 ,2)->default(0)->after('discount_value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bills', function (Blueprint $table) {
            //
        });
    }
}
