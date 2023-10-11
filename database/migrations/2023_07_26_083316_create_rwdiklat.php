<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRwdiklat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rwdiklat', function (Blueprint $table) {
            $table->id();
            $table->string('pegawaiID',50)->nullable();
            $table->string('nip',50)->nullable();
            $table->string('nama',250)->nullable();
            $table->string('jenis',2)->nullable();
            $table->string('tgl',25)->nullable();
            $table->string('nama_diklat',250)->nullable();
            $table->string('diklat_struktural',50)->nullable();
            $table->string('created_by',250)->nullable();
            $table->timestamps();
            $table->index(['nip','diklat_struktural']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rwdiklat');
    }
}
