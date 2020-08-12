<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTransaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('srtf_transaksi', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_peserta')->nullable();
            $table->string('id_seminar')->nullable();
            $table->decimal('jumlah', 20, 0)->default(0);
            $table->string('status')->default('pending');
            $table->timestamps();
        });


        Schema::create('srtf_log_transaksi', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_transaksi')->nullable();
            $table->string('keterangan')->nullable();
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
        Schema::dropIfExists('srtf_transaksi');
        Schema::dropIfExists('srtf_log_transaksi');
    }
}
