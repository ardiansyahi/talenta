<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKonfigurasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('konfigurasi_krs', function (Blueprint $table) {
            $table->id();
            $table->integer('id_krs')->nullable();
            $table->string('jenis','35')->nullable();
            $table->string('kriteria',255)->nullable();
            $table->longText('isidata')->nullable();
            $table->string('created_by',100)->nullable();
            $table->timestamps();
            $table->string('updated_by',100)->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('konfigurasi_krs');
    }
}
