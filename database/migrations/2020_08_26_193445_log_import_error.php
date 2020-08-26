<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LogImportError extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        if (!Schema::hasTable('srtf_log_import_error')) {
            Schema::create('srtf_log_import_error', function (Blueprint $table) {
                $table->bigIncrements('id');;
                $table->bigInteger('import_id');
                $table->bigInteger('user_id');
                $table->string('status_daftar');
                $table->string('status');
                $table->string('note');
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
