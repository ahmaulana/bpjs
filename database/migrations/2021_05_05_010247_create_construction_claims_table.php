<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConstructionClaimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('construction_claims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('claim_id')->constrained('claims')->onDelete('cascade')->onUpdate('cascade');
            $table->string('npp');
            $table->string('nama_proyek');
            $table->string('alamat_proyek');
            $table->string('jenis_pemilik');
            $table->string('nama_pemilik');
            $table->string('dokumen_spk');
            $table->string('file_formulir_pengajuan');
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
        Schema::dropIfExists('construction_claims');
    }
}
