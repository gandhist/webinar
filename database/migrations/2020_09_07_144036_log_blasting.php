<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LogBlasting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (!Schema::hasTable('srtf_log_blasting')) {
            Schema::create('srtf_log_blasting', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('id_seminar');
                $table->string('kirim_email');
                $table->string('kirim_wa');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
