<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConstructionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('constructions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('npp');
            $table->string('nama_proyek');
            $table->text('alamat_proyek');
            $table->integer('nilai_proyek');
            $table->string('sumber_pembiayaan');
            $table->string('jenis_pemilik');
            $table->string('nama_pemilik');
            $table->string('npp_pelaksana');
            $table->string('no_spk');
            $table->string('dokumen_spk');
            $table->integer('masa_kontrak');
            $table->dateTime('masa_pemeliharaan')->nullable();
            $table->integer('total_pekerja');
            $table->string('cara_pembayaran');
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
        Schema::dropIfExists('constructions');
    }
}
