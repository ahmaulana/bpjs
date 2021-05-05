<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWageClaimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wage_claims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('claim_id')->constrained('claims')->onDelete('cascade')->onUpdate('cascade');
            $table->string('no_kpj');
            $table->string('tempat_lahir');
            $table->dateTime('tgl_lahir');
            $table->string('nama_ibu');
            $table->text('alamat');
            $table->string('kabupaten');
            $table->string('kecamatan');
            $table->string('file_kartu_bpjs');
            $table->string('file_kk');
            $table->string('file_suket');
            $table->string('file_formulir_jht');
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
        Schema::dropIfExists('wage_claims');
    }
}
