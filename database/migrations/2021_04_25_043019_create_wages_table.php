<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('nik');
            $table->dateTime('tgl_lahir');
            $table->text('lokasi_bekerja');
            $table->string('pekerjaan');
            $table->string('jam_kerja');
            $table->integer('penghasilan');
            $table->string('program');
            $table->string('periode_pembayaran')->nullable();
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
        Schema::dropIfExists('wages');
    }
}
