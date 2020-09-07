<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TargetBlasting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (!Schema::hasTable('srtf_target_blasting')) {
            Schema::create('srtf_target_blasting', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nama')->nullable();
                $table->string('email')->nullable();
                $table->string('no_hp')->nullable();
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
