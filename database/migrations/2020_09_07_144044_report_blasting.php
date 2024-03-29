<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReportBlasting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (!Schema::hasTable('srtf_report_blasting')) {
            Schema::create('srtf_report_blasting', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('id_target')->nullable();
                $table->string('id_seminar')->nullable();
                $table->string('is_email_sent')->nullable();
                $table->string('is_wa_sent')->nullable();
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
