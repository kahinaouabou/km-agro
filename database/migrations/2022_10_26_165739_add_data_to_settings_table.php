<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql="INSERT INTO `settings` (`id`, `name`, `payment_ref_auto`, `payment_date_position`, 
        `payment_prefix`, `payment_size`, `payment_next_ref`, `created_at`, `updated_at`) 
        VALUES ('1', 'reference', '1', '1', 'P', '4', '1', '2022-10-26 17:55:10', '2022-10-26 17:55:10')";
    
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
