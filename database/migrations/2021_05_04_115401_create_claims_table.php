<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClaimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claims', function (Blueprint $table) {
            $table->id();            
            $table->string('nama');                                                
            $table->string('no_hp');
            $table->string('email');
            $table->enum('jenis_kepesertaan',['pu','bpu','jk']);
            $table->string('program');
            $table->enum('bank',['bni','bca','bri','mandiri']);
            $table->string('no_rekening');
            $table->string('sebab_klaim');            
            $table->string('file_ktp');                        
            $table->string('file_buku_rekening');
            $table->string('file_foto');            
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('claims');
    }
}
