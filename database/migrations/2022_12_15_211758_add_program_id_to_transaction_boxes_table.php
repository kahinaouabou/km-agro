<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProgramIdToTransactionBoxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_boxes', function (Blueprint $table) {
            //
            $table->integer('program_id')->after('third_party_id')
            ->foreign('program_id')->references('id')
            ->on('programs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaction_boxes', function (Blueprint $table) {
            //
        });
    }
}
