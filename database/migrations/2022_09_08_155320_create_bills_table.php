<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->date('bill_date');
            $table->integer('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->integer('truck_id');
            $table->foreign('truck_id')->references('id')->on('trucks')->onDelete('cascade');
            $table->boolean('origin');
            $table->integer('parcel_id')->nullable();
            $table->foreign('parcel_id')->references('id')->on('parcels')->onDelete('cascade');
            $table->integer('third_party_id')->nullable();
            $table->foreign('third_party_id')->references('id')->on('thirdParties')->onDelete('cascade');
            $table->integer('block_id');
            $table->foreign('block_id')->references('id')->on('blocks')->onDelete('cascade');
            $table->integer('room_id');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->decimal('number_boxes',10 ,2)->default(0);
            $table->decimal('raw',10 ,2)->default(0);
            $table->decimal('tare',10 ,2)->default(0);
            $table->decimal('net',10 ,2)->default(0);
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
        Schema::dropIfExists('bills');
    }
}
