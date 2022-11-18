<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rooms', function (Blueprint $table) {
            //
            $table->decimal('unstocked_quantity', 10,2)->default(0)->after('stored_quantity');
            $table->decimal('damaged_quantity',10,2)->default(0)->after('unstocked_quantity');
            $table->decimal('weightloss_value',10,2)->default(0)->after('damaged_quantity');
            $table->decimal('loss_percentage',10,2)->default(0)->after('weightloss_value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rooms', function (Blueprint $table) {
            //
        });
    }
}
