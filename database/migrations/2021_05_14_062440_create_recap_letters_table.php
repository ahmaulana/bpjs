<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecapLettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recap_letters', function (Blueprint $table) {
            $table->id();
            $table->string('npp');
            $table->string('nama_perusahaan');
            $table->string('program');
            $table->string('pernyataan');
            $table->string('lampiran');
            $table->dateTime('tgl');
            $table->boolean('kop_surat');
            $table->boolean('materai');
            $table->boolean('ttd');
            $table->boolean('rekening');
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
        Schema::dropIfExists('recap_letters');
    }
}
