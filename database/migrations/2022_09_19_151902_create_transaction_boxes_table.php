<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionBoxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_boxes', function (Blueprint $table) {
            $table->id();
            $table->date('transaction_date');
            $table->decimal('number_boxes_retourned',10,2)->default(0);
            $table->decimal('number_boxes_taken',10,2)->nullable(false)->default(0);
            $table->integer('bill_id')->nullable(true);
            $table->foreign('bill_id')->references('id')->on('bills')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_boxes');
    }
}
